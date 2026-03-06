<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recycle_bin extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recycle_bin_model');
    }

    public function index() {
        $this->data['title'] = 'Recycle Bin';
        
        $tables = $this->Recycle_bin_model->get_vault_tables();
        $counts = [];
        $total = 0;
        foreach ($tables as $t) {
            $cnt = $this->Recycle_bin_model->get_deleted_count($t);
            $counts[$t] = $cnt;
            $total += $cnt;
        }

        $this->data['tables'] = $tables;
        $this->data['counts'] = $counts;
        $this->data['total'] = $total;
        
        $this->template->load('admin/recycle_bin/index', $this->data);
    }

    public function get_data($type) {
        $data = array();
        
        if ($type == 'all') {
            $tables = $this->Recycle_bin_model->get_vault_tables();
            foreach ($tables as $t) {
                $res = $this->Recycle_bin_model->get_deleted_data($t);
                $data = array_merge($data, $res);
            }
            
            usort($data, function($a, $b) {
                return strtotime($b['deleted_at']) - strtotime($a['deleted_at']);
            });
        } else {
            // $type is the specific table name
            $data = $this->Recycle_bin_model->get_deleted_data($type);
        }
        
        echo json_encode($data);
    }

    public function restore() {
        $id = $this->input->post('id');
        $type = $this->input->post('type'); // type is table name

        if ($this->Recycle_bin_model->restore($type, $id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dikembalikan ke modul asalnya.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengembalikan data.'));
        }
    }

    public function hard_delete() {
        $id = $this->input->post('id');
        $type = $this->input->post('type');

        if ($type == 'users' && $id == 1) {
            echo json_encode(array('status' => 'error', 'message' => 'Akun Super Admin root tidak dapat dihancurkan!'));
            return;
        }
        if ($type == 'roles' && $id == 1) {
            echo json_encode(array('status' => 'error', 'message' => 'Role Root tidak dapat dihancurkan!'));
            return;
        }

        if ($this->Recycle_bin_model->hard_delete($type, $id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dihancurkan secara permanen (Vaporized).'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghancurkan data fisik.'));
        }
    }

    public function empty_bin() {
        if ($this->Recycle_bin_model->empty_bin()) {
            echo json_encode(array('status' => 'success', 'message' => 'Seluruh tempat sampah telah dikosongkan secara permanen.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengosongkan tempat sampah.'));
        }
    }
}
