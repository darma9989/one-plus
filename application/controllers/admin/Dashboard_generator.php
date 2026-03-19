<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_generator extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('Crud_generator_model'); // Untuk list tabel
    }

    public function index() {
        $this->data['title'] = 'Dashboard Builder (Premium)';
        $this->data['widgets'] = $this->Dashboard_model->get_all_widgets_management();
        $this->data['tables'] = $this->Crud_generator_model->get_tables();
        
        $this->template->load('admin/dashboard_generator/index', $this->data);
    }

    public function save() {
        $id = $this->input->post('id', TRUE);
        $data = array(
            'title'        => strtoupper($this->input->post('title', TRUE)),
            'type'         => $this->input->post('type', TRUE),
            'table_source' => $this->input->post('table_source', TRUE),
            'calc_field'   => $this->input->post('calc_field', TRUE) ? $this->input->post('calc_field', TRUE) : 'id',
            'calc_type'    => $this->input->post('calc_type', TRUE),
            'icon'         => $this->input->post('icon', TRUE),
            'color'        => $this->input->post('color', TRUE),
            'grid_size'    => $this->input->post('grid_size', TRUE),
            'order_num'    => $this->input->post('order_num', TRUE),
            'is_active'    => $this->input->post('is_active', TRUE) ? 1 : 0,
            'updated_at'   => date('Y-m-d H:i:s')
        );

        if (!$id) $data['created_at'] = date('Y-m-d H:i:s');

        if ($this->Dashboard_model->save($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Widget Dashboard berhasil dikonfigurasi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan konfigurasi widget.']);
        }
    }

    public function get_widget_data() {
        $id = $this->input->post('id', TRUE);
        $this->db->where('id', $id);
        $data = $this->db->get('dashboard_widgets')->row_array();
        echo json_encode($data);
    }

    public function delete() {
        $id = $this->input->post('id', TRUE);
        if ($this->Dashboard_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Widget berhasil dihapus.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus widget.']);
        }
    }
}
