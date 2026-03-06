<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mitra_model');
    }

    public function index() {
        $this->data['title'] = 'Manajemen Mitra';
        $this->data['records'] = $this->Mitra_model->get_all();
        $this->template->load('admin/mitra/index', $this->data);
    }

    public function get_data() {
        $id = $this->input->post('id', TRUE);
        $data = $this->Mitra_model->get_mitra($id);
        echo json_encode($data);
    }

    public function save() {
        $id = $this->input->post('id', TRUE);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nama_mitra', 'Nama mitra', 'required|trim');
        $this->form_validation->set_rules('created', 'Created', 'required|trim');
        $this->form_validation->set_rules('updated', 'Updated', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = array(
                'nama' => strtoupper($this->input->post('nama', TRUE)),
                'nama_mitra' => strtoupper($this->input->post('nama_mitra', TRUE)),
                'created' => strtoupper($this->input->post('created', TRUE)),
                'updated' => strtoupper($this->input->post('updated', TRUE)),
            );

            if ($id) {
                $res = $this->Mitra_model->update($id, $data);
                $msg = 'Data berhasil diperbarui.';
            } else {
                $res = $this->Mitra_model->insert($data);
                $msg = 'Data berhasil ditambahkan.';
            }

            if ($res) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data.']);
            }
        }
    }

    public function delete() {
        $id = $this->input->post('id', TRUE);
        if ($this->Mitra_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }

    public function import_excel() {
        $data_raw = $this->input->post('data', TRUE);
        if (empty($data_raw)) {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data untuk diimport.']);
            return;
        }

        $data = [];
        foreach ($data_raw as $row) {
            $item = [
                'created_at' => date('Y-m-d H:i:s')
            ];
            $item['nama'] = strtoupper(isset($row['nama']) ? $row['nama'] : '');
            $item['nama_mitra'] = strtoupper(isset($row['nama_mitra']) ? $row['nama_mitra'] : '');
            $item['created'] = strtoupper(isset($row['created']) ? $row['created'] : '');
            $item['updated'] = strtoupper(isset($row['updated']) ? $row['updated'] : '');
            $data[] = $item;
        }

        if ($this->Mitra_model->insert_batch($data)) {
            echo json_encode(['status' => 'success', 'message' => count($data) . ' Data berhasil diimport.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengimport data balance.']);
        }
    }
}
