<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Roles Controller — Role Management & Permission Matrix
 */
class Roles extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Role_model');
        $this->load->model('Permission_model');
        $this->load->model('Menu_model');
    }

    public function index() {
        $this->data['title'] = 'Role Management';
        $roles = $this->Role_model->get_all();
        foreach ($roles as &$role) {
            $role['user_count'] = $this->Role_model->count_users($role['id']);
        }
        $this->data['roles'] = $roles;
        $this->data['menus'] = $this->Menu_model->get_menu_tree();
        $this->template->load('admin/roles/index', $this->data);
    }

    public function add() {
        $this->form_validation->set_rules('role_name', 'Nama Role', 'required|is_unique[roles.role_name]');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'message' => validation_errors()));
        } else {
            $data = array(
                'role_name'          => $this->input->post('role_name'),
                'description'        => $this->input->post('description'),
                'can_add_user'       => $this->input->post('can_add_user') ? 1 : 0,
                'can_view_all_users' => $this->input->post('can_view_all_users') ? 1 : 0
            );
            if ($this->Role_model->insert($data)) {
                echo json_encode(array('status' => 'success', 'message' => 'Role berhasil ditambahkan.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal menambahkan role.'));
            }
        }
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'role_name'          => $this->input->post('role_name'),
            'description'        => $this->input->post('description'),
            'can_add_user'       => $this->input->post('can_add_user') ? 1 : 0,
            'can_view_all_users' => $this->input->post('can_view_all_users') ? 1 : 0
        );
        if ($this->Role_model->update($id, $data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Role berhasil diupdate.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate role.'));
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($this->Role_model->delete($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Role berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus role. Role superadmin tidak bisa dihapus.'));
        }
    }

    public function get_permissions() {
        $role_id = $this->input->post('role_id');
        $permissions = $this->Permission_model->get_permissions($role_id);
        echo json_encode($permissions);
    }

    public function save_permissions() {
        $role_id = $this->input->post('role_id');
        $menu_ids = $this->input->post('menu_ids');
        if (!is_array($menu_ids)) $menu_ids = array();

        if ($this->Permission_model->save_permissions($role_id, $menu_ids)) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'PERMISSIONS',
                'item_id'   => $role_id,
                'action'    => 'UPDATE',
                'after'     => array('menu_ids' => $menu_ids)
            ));
            echo json_encode(array('status' => 'success', 'message' => 'Permission berhasil disimpan.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan permission.'));
        }
    }
}
