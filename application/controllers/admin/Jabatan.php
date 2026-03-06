<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jabatan_model');
    }

    public function index() {
        $this->data['title'] = 'Manajemen Jabatan';
        $this->data['jabatan'] = $this->Jabatan_model->get_all();
        $this->template->load('admin/jabatan/index', $this->data);
    }

    public function get_jabatan() {
        $id = $this->input->post('id', TRUE);
        $data = $this->Jabatan_model->get_jabatan($id);
        echo json_encode($data);
    }

    public function add() {
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required|trim|is_unique[jabatan.nama_jabatan]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = array(
                'nama_jabatan'  => strtoupper($this->input->post('nama_jabatan', TRUE)),
                'deskripsi'     => ucwords($this->input->post('deskripsi', TRUE))
            );
            if ($this->Jabatan_model->insert($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Jabatan berhasil ditambahkan.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan jabatan.']);
            }
        }
    }

    public function update() {
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $id = $this->input->post('id', TRUE);
            $data = array(
                'nama_jabatan'  => strtoupper($this->input->post('nama_jabatan', TRUE)),
                'deskripsi'     => ucwords($this->input->post('deskripsi', TRUE))
            );
            if ($this->Jabatan_model->update($id, $data)) {
                echo json_encode(['status' => 'success', 'message' => 'Jabatan berhasil diperbarui.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui jabatan.']);
            }
        }
    }

    public function delete() {
        $id = $this->input->post('id', TRUE);
        if ($this->Jabatan_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Jabatan berhasil dihapus (Soft Delete).']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus jabatan.']);
        }
    }
}
