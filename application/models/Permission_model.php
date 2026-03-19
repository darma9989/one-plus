<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permission_model — Dynamic Permission per Menu
 */
class Permission_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Cek apakah role punya akses ke URI tertentu
     */
    public function has_access($role_id, $current_uri) {
        // Cek apakah superadmin (akses semua)
        $role = $this->db->get_where('roles', array('id' => $role_id))->row();
        if ($role && $role->is_superadmin == 1) {
            return TRUE;
        }

        // URI base yang selalu diizinkan
        $allowed_prefixes = array('dashboard', 'auth/login', 'auth/logout', 'admin/profile');
        $current_uri = trim($current_uri, '/');
        
        foreach ($allowed_prefixes as $prefix) {
            if (strpos($current_uri, $prefix) === 0) {
                return TRUE;
            }
        }

        // Ambil semua menu_link yang diizinkan untuk role ini
        $this->db->select('m.menu_link');
        $this->db->from('menu m');
        $this->db->join('role_permissions rp', 'm.id = rp.menu_id');
        $this->db->where('rp.role_id', $role_id);
        $this->db->where('m.menu_status', 1);
        $permissions = $this->db->get()->result_array();

        foreach ($permissions as $p) {
            $link = trim($p['menu_link'], '/');
            if (empty($link) || $link == '#') continue;
            // Cek apakah current URI dimulai dari menu_link (untuk sub-routes)
            if (strpos($current_uri, $link) === 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Ambil menu tree untuk role tertentu
     */
    public function get_menu_for_role($role_id) {
        // Cek superadmin
        $role = $this->db->get_where('roles', array('id' => $role_id))->row();
        if ($role && $role->is_superadmin == 1) {
            // Superadmin dapat semua menu aktif
            $this->db->where('menu_status', 1);
            $this->db->order_by('menu_order', 'ASC');
            $all_menus = $this->db->get('menu')->result_array();
        } else {
            $this->db->select('m.*');
            $this->db->from('menu m');
            $this->db->join('role_permissions rp', 'm.id = rp.menu_id');
            $this->db->where('rp.role_id', $role_id);
            $this->db->where('m.menu_status', 1);
            $this->db->order_by('m.menu_order', 'ASC');
            $all_menus = $this->db->get()->result_array();

            // Tambahkan parent menu yang mungkin tidak di-assign tapi punya child yang di-assign
            $parent_ids = array();
            foreach ($all_menus as $m) {
                if (!empty($m['parent_id'])) {
                    $parent_ids[] = $m['parent_id'];
                }
            }
            $existing_ids = array();
            foreach ($all_menus as $m) {
                $existing_ids[] = $m['id'];
            }
            $missing_parents = array_diff($parent_ids, $existing_ids);
            if (!empty($missing_parents)) {
                $this->db->where_in('id', $missing_parents);
                $this->db->where('menu_status', 1);
                $parents = $this->db->get('menu')->result_array();
                $all_menus = array_merge($all_menus, $parents);
                // Sort ulang
                usort($all_menus, function($a, $b) {
                    return $a['menu_order'] - $b['menu_order'];
                });
            }
        }

        return $this->build_tree($all_menus);
    }

    /**
     * Build tree structure dari flat menu data
     */
    private function build_tree($menus, $parent_id = NULL) {
        $branch = array();
        foreach ($menus as $menu) {
            $menu_parent = $menu['parent_id'];
            if ($menu_parent == $parent_id) {
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
     * Simpan permissions untuk sebuah role
     */
    public function save_permissions($role_id, $menu_ids) {
        $this->db->trans_start();

        // Hapus permission lama
        $this->db->where('role_id', $role_id);
        $this->db->delete('role_permissions');

        // Insert permission baru
        if (!empty($menu_ids)) {
            $data = array();
            foreach ($menu_ids as $mid) {
                $data[] = array('role_id' => $role_id, 'menu_id' => $mid);
            }
            $this->db->insert_batch('role_permissions', $data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Ambil daftar menu_id yang diizinkan untuk role
     */
    public function get_permissions($role_id) {
        $this->db->select('menu_id');
        $this->db->where('role_id', $role_id);
        $result = $this->db->get('role_permissions')->result_array();
        $ids = array();
        foreach ($result as $r) {
            $ids[] = $r['menu_id'];
        }
        return $ids;
    }
}
