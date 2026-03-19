<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_insera extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_insera_model');
    }

    public function index() {
        $this->data['title'] = 'Dashboard Insera';
        $this->data['stats'] = $this->Dashboard_insera_model->get_stats();
        $this->data['pivot_open'] = $this->Dashboard_insera_model->get_pivot_by_category('OPEN');
        $this->data['pivot_closed'] = $this->Dashboard_insera_model->get_pivot_by_category('CLOSED');
        $this->data['last_update'] = $this->Dashboard_insera_model->get_last_update();

        $this->template->load('admin/dashboard/insera_index', $this->data);
    }

    public function ajax_get_detail_tickets() {
        $params = array(
            'scrape_category' => $this->input->post('scrape_category', TRUE),
            'work_zone' => $this->input->post('work_zone', TRUE),
            'status_type' => $this->input->post('status_type', TRUE),
            'bucket' => $this->input->post('bucket', TRUE)
        );
        
        $data = $this->Dashboard_insera_model->get_detail_tickets($params);
        
        echo json_encode(array(
            'data' => $data,
            'csrf_token' => $this->security->get_csrf_hash()
        ));
    }
}
