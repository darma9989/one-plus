<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Material_model');
    }

    public function index() {
        $this->data['title'] = 'Manajemen Material';
        $this->data['records'] = $this->Material_model->get_all();
        $this->template->load('admin/material/index', $this->data);
    }

    public function get_data() {
        $id = $this->input->post('id', TRUE);
        $data = $this->Material_model->get_material($id);
        echo json_encode($data);
    }

    public function save() {
        $id = $this->input->post('id', TRUE);
        $this->form_validation->set_rules('designator', 'Designator', 'required|trim');
        $this->form_validation->set_rules('nama_material', 'Nama material', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = array(
                'designator' => strtoupper($this->input->post('designator', TRUE)),
                'nama_material' => strtoupper($this->input->post('nama_material', TRUE)),
                'satuan' => strtoupper($this->input->post('satuan', TRUE)),
            );

            if ($id) {
                $res = $this->Material_model->update($id, $data);
                $msg = 'Data berhasil diperbarui.';
            } else {
                $res = $this->Material_model->insert($data);
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
        if ($this->Material_model->delete($id)) {
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
            $item['designator'] = strtoupper(isset($row['designator']) ? $row['designator'] : '');
            $item['nama_material'] = strtoupper(isset($row['nama_material']) ? $row['nama_material'] : '');
            $item['satuan'] = strtoupper(isset($row['satuan']) ? $row['satuan'] : '');
            $data[] = $item;
        }

        if ($this->Material_model->insert_batch($data)) {
            echo json_encode(['status' => 'success', 'message' => count($data) . ' Data berhasil diimport.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengimport data balance.']);
        }
    }
}
