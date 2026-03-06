<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menu_model — Menu Hierarchical CRUD
 */
class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil semua menu dalam bentuk tree
     */
    public function get_menu_tree() {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('menu_order', 'ASC');
        $menus = $this->db->get('menu')->result_array();
        return $this->build_tree($menus);
    }

    /**
     * Build tree recursive
     */
    private function build_tree($menus, $parent_id = NULL) {
        $branch = array();
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parent_id) {
                $children = $this->build_tree($menus, $menu['id']);
                if ($children) {
                    $menu['children'] = $children;
                }
                $branch[] = $menu;
            }
        }
        return $branch;
    }

    /**
     * Ambil semua menu flat (untuk dropdown parent)
     */
    public function get_all() {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('menu_order', 'ASC');
        return $this->db->get('menu')->result_array();
    }

    /**
     * Ambil parent menus (yang tidak punya parent)
     */
    public function get_parents() {
        $this->db->where('parent_id IS NULL');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('menu_order', 'ASC');
        return $this->db->get('menu')->result_array();
    }

    /**
     * Ambil menu by ID
     */
    public function get_menu($id) {
        return $this->db->get_where('menu', array('id' => $id, 'deleted_at' => NULL))->row_array();
    }

    /**
     * Insert menu baru
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert('menu', $data);
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'MENU',
                'item_id'   => $this->db->insert_id(),
                'item_name' => $data['menu_name'],
                'action'    => 'CREATE',
                'after'     => $data
            ));
        }
        return $result;
    }

    /**
     * Update menu
     */
    public function update($id, $data) {
        $old_data = $this->get_menu($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $result = $this->db->update('menu', $data);
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'MENU',
                'item_id'   => $id,
                'item_name' => $old_data['menu_name'],
                'action'    => 'UPDATE',
                'before'    => $old_data,
                'after'     => $data
            ));
        }
        return $result;
    }

    /**
     * Hapus menu beserta SEMUA keturunannya (Deep Soft Delete)
     */
    public function delete($id) {
        $old_data = $this->get_menu($id);
        if (!$old_data) return FALSE;

        $data = array('deleted_at' => date('Y-m-d H:i:s'));
        
        $this->db->trans_start();

        // Ambil semua ID keturunan
        $all_ids = $this->get_all_descendant_ids($id);
        $all_ids[] = $id;

        // Soft delete semua
        $this->db->where_in('id', $all_ids);
        $this->db->update('menu', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'MENU',
                'item_id'   => $id,
                'item_name' => $old_data['menu_name'],
                'action'    => 'DELETE',
                'before'    => $old_data
            ));
        }
        return $this->db->trans_status();
    }

    /**
     * Restore menu beserta SEMUA keturunannya (Deep Restore)
     */
    public function restore($id) {
        $this->db->trans_start();
        
        // Ambil semua ID keturunan yang juga terhapus
        $all_ids = $this->get_all_descendant_ids_deleted($id);
        $all_ids[] = $id;

        $this->db->where_in('id', $all_ids);
        $this->db->update('menu', array('deleted_at' => NULL));

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_deleted() {
        $this->db->where('deleted_at IS NOT NULL');
        $this->db->order_by('deleted_at', 'DESC');
        return $this->db->get('menu')->result_array();
    }

    private function get_all_descendant_ids_deleted($parent_id) {
        $ids = array();
        $this->db->select('id');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('deleted_at IS NOT NULL');
        $children = $this->db->get('menu')->result_array();
        
        foreach ($children as $child) {
            $ids[] = $child['id'];
            $ids = array_merge($ids, $this->get_all_descendant_ids_deleted($child['id']));
        }
        return $ids;
    }

    /**
     * Helper untuk ambil semua ID anak, cucu, cicit...
     */
    private function get_all_descendant_ids($parent_id) {
        $ids = array();
        $this->db->select('id');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('deleted_at IS NULL');
        $children = $this->db->get('menu')->result_array();
        
        foreach ($children as $child) {
            $ids[] = $child['id'];
            $ids = array_merge($ids, $this->get_all_descendant_ids($child['id']));
        }
        return $ids;
    }

    /**
     * Update urutan menu (dari drag & drop)
     */
    public function update_order($items) {
        if (empty($items)) return FALSE;

        $this->db->trans_start();
        foreach ($items as $item) {
            if (!isset($item['id'])) continue;
            $parent_id = NULL;
            if (isset($item['parent_id']) && $item['parent_id'] !== '' && $item['parent_id'] !== 'null') {
                $parent_id = intval($item['parent_id']);
            }
            $this->db->where('id', intval($item['id']));
            $this->db->update('menu', array(
                'menu_order' => isset($item['order']) ? intval($item['order']) : 0,
                'parent_id'  => $parent_id,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Ambil breadcrumb path secara rekursif (Infinite Depth Support)
     */
    public function get_breadcrumb($uri) {
        if (empty($uri) || $uri == 'dashboard' || $uri == 'admin/dashboard') {
            return array();
        }

        // Cari menu berdasarkan link
        $this->db->where('menu_link', $uri);
        $this->db->where('deleted_at IS NULL');
        $curr = $this->db->get('menu')->row_array();

        if (!$curr) {
            // Coba cari yang mirip (fallback)
            $parts = explode('/', $uri);
            if (count($parts) > 1) {
                $base_uri = $parts[0] . '/' . $parts[1];
                $this->db->where('menu_link', $base_uri);
                $this->db->where('deleted_at IS NULL');
                $curr = $this->db->get('menu')->row_array();
            }
        }

        if (!$curr) return array();

        $breadcrumbs = array();
        $this->build_breadcrumb_recursive($curr, $breadcrumbs);
        
        return $breadcrumbs;
    }

    private function build_breadcrumb_recursive($menu, &$breadcrumbs) {
        // Jika punya parent, proses parent dulu (agar urutannya benar)
        if ($menu['parent_id']) {
            $parent = $this->get_menu($menu['parent_id']);
            if ($parent) {
                $this->build_breadcrumb_recursive($parent, $breadcrumbs);
            }
        }
        
        $breadcrumbs[] = array(
            'name' => $menu['menu_name'], 
            'link' => $menu['menu_link'] ? $menu['menu_link'] : '#', 
            'icon' => $menu['menu_icon']
        );
    }
    public function hard_delete($id) {
        $this->db->trans_start();

        // Ambil semua keturunan
        $children_ids = $this->get_all_children_ids($id);
        
        // Gabung ID yang mau dihapus dgn anak2nya
        $all_ids = $children_ids;
        $all_ids[] = $id;

        // Ambil info nama menu root
        $this->db->where('id', $id);
        $menu = $this->db->get('menu')->row_array();

        if ($menu) {
            $this->db->where_in('id', $all_ids);
            $this->db->delete('menu');

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->Log_model->write(array(
                    'module'    => 'SYSTEM',
                    'sub_module'=> 'MENU',
                    'item_id'   => $id,
                    'item_name' => $menu['menu_name'],
                    'action'    => 'HARD_DELETE'
                ));
            }
        }
        return $this->db->trans_status();
    }
}
