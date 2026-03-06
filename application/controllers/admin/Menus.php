<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model');
    }

    public function index() {
        $this->data['title'] = 'Menu Management';
        $this->data['menus'] = $this->Menu_model->get_menu_tree();
        $this->data['parent_menus'] = $this->Menu_model->get_parents();
        $this->template->load('admin/menus/index', $this->data);
    }

    public function get_menu() {
        $id = $this->input->post('id');
        echo json_encode($this->Menu_model->get_menu($id));
    }

    public function add() {
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'message' => validation_errors()));
        } else {
            $data = array(
                'menu_name'  => $this->input->post('menu_name'),
                'menu_icon'  => $this->input->post('menu_icon') ? $this->input->post('menu_icon') : 'fa fa-circle-o',
                'menu_link'  => $this->input->post('menu_link'),
                'menu_order' => $this->input->post('menu_order') ? $this->input->post('menu_order') : 0,
                'menu_status'=> $this->input->post('menu_status') !== NULL ? $this->input->post('menu_status') : 1,
                'parent_id'  => $this->input->post('parent_id') ? $this->input->post('parent_id') : NULL
            );
            if ($this->Menu_model->insert($data)) {
                echo json_encode(array('status' => 'success', 'message' => 'Menu berhasil ditambahkan.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal menambahkan menu.'));
            }
        }
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'menu_name'  => $this->input->post('menu_name'),
            'menu_icon'  => $this->input->post('menu_icon') ? $this->input->post('menu_icon') : 'fa fa-circle-o',
            'menu_link'  => $this->input->post('menu_link'),
            'menu_order' => $this->input->post('menu_order'),
            'menu_status'=> $this->input->post('menu_status'),
            'parent_id'  => $this->input->post('parent_id') ? $this->input->post('parent_id') : NULL
        );
        if ($this->Menu_model->update($id, $data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Menu berhasil diupdate.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate menu.'));
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($this->Menu_model->delete($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Menu berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus menu.'));
        }
    }

    public function update_order() {
        $items = $this->input->post('items');
        if ($this->Menu_model->update_order($items)) {
            echo json_encode(array('status' => 'success', 'message' => 'Urutan menu berhasil diupdate.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate urutan.'));
        }
    }

    public function restore() {
        $id = $this->input->post('id');
        if ($this->Menu_model->restore($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Menu berhasil dikembalikan.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengembalikan menu.'));
        }
    }

    public function get_deleted() {
        $data = $this->Menu_model->get_deleted();
        echo json_encode($data);
    }
}
