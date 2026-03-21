<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_insera extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_insera_model');
    }

    public function index() {
        $resolve_date_from = $this->input->get('resolve_date_from', TRUE);
        $resolve_date_to = $this->input->get('resolve_date_to', TRUE);
        $resolve_date_from = $this->_sanitize_date($resolve_date_from);
        $resolve_date_to = $this->_sanitize_date($resolve_date_to);
        if (!empty($resolve_date_from) && !empty($resolve_date_to) && $resolve_date_from > $resolve_date_to) {
            $tmp = $resolve_date_from;
            $resolve_date_from = $resolve_date_to;
            $resolve_date_to = $tmp;
        }

        $this->data['title'] = 'Dashboard Insera';
        $this->data['stats'] = $this->Dashboard_insera_model->get_stats();
        $this->data['pivot_open'] = $this->Dashboard_insera_model->get_pivot_by_category('OPEN');
        $this->data['pivot_star'] = $this->Dashboard_insera_model->get_pivot_by_category('OPEN', array('HSI', 'PL-TSEL'));
        $this->data['pivot_closed'] = $this->Dashboard_insera_model->get_pivot_by_category('CLOSED', array(), $resolve_date_from, $resolve_date_to);
        $this->data['pivot_pltsel_cust'] = $this->Dashboard_insera_model->get_pivot_by_customer_type('PL-TSEL', 'OPEN');
        $this->data['pivot_pltsel_diamond']  = $this->Dashboard_insera_model->get_pivot_pltsel_by_cust_group('HVC_DIAMOND');
        $this->data['pivot_pltsel_platinum'] = $this->Dashboard_insera_model->get_pivot_pltsel_by_cust_group('HVC_PLATINUM');
        $this->data['pivot_pltsel_gold']     = $this->Dashboard_insera_model->get_pivot_pltsel_by_cust_group('HVC_GOLD');
        $this->data['pivot_pltsel_reguler']  = $this->Dashboard_insera_model->get_pivot_pltsel_by_cust_group('REGULER / BLANK');
        $this->data['last_update'] = $this->Dashboard_insera_model->get_last_update();
        $this->data['resolve_date_from'] = $resolve_date_from;
        $this->data['resolve_date_to'] = $resolve_date_to;

        $this->template->load('admin/dashboard/insera_index', $this->data);
    }

    public function ajax_get_detail_tickets() {
        $params = array(
            'scrape_category' => $this->input->post('scrape_category', TRUE),
            'work_zone' => $this->input->post('work_zone', TRUE),
            'status_type' => $this->input->post('status_type', TRUE),
            'bucket' => $this->input->post('bucket', TRUE),
            'customer_type' => $this->input->post('customer_type', TRUE),
            'resolve_date_from' => $this->_sanitize_date($this->input->post('resolve_date_from', TRUE)),
            'resolve_date_to' => $this->_sanitize_date($this->input->post('resolve_date_to', TRUE))
        );
        
        $data = $this->Dashboard_insera_model->get_detail_tickets($params);
        
        echo json_encode(array(
            'data' => $data,
            'csrf_token' => $this->security->get_csrf_hash()
        ));
    }

    private function _sanitize_date($date_value) {
        if (empty($date_value)) return '';
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_value) !== 1) return '';
        $dt = DateTime::createFromFormat('Y-m-d', $date_value);
        if (!$dt || $dt->format('Y-m-d') !== $date_value) return '';
        return $date_value;
    }
}
