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

    public function export_closed_category_excel() {
        $category = $this->input->get('category', TRUE);
        $resolve_date_from = $this->_sanitize_date($this->input->get('resolve_date_from', TRUE));
        $resolve_date_to = $this->_sanitize_date($this->input->get('resolve_date_to', TRUE));
        if (!empty($resolve_date_from) && !empty($resolve_date_to) && $resolve_date_from > $resolve_date_to) {
            $tmp = $resolve_date_from;
            $resolve_date_from = $resolve_date_to;
            $resolve_date_to = $tmp;
        }

        if (empty($category)) {
            show_error('Kategori tidak valid.', 400);
            return;
        }

        $rows = $this->Dashboard_insera_model->get_closed_export_tickets_by_category($category, $resolve_date_from, $resolve_date_to);

        $safe_category = preg_replace('/[^A-Za-z0-9_\-]/', '_', $category);
        $date_part = (!empty($resolve_date_from) || !empty($resolve_date_to))
            ? '_' . (!empty($resolve_date_from) ? $resolve_date_from : 'all') . '_to_' . (!empty($resolve_date_to) ? $resolve_date_to : 'all')
            : '_all_dates';
        $filename = 'closed_' . $safe_category . $date_part . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, array('Ticket ID', 'Service No', 'RK Information', 'Pipe Name', 'Workzone', 'Customer Type', 'Reported Date', 'Resolve Date', 'Ticket Status', 'TTR Customer', 'Summary'));

        foreach ($rows as $r) {
            fputcsv($output, array(
                isset($r['ticket_id']) ? $r['ticket_id'] : '',
                isset($r['service_no']) ? $r['service_no'] : '',
                isset($r['rk_information']) ? $r['rk_information'] : '',
                isset($r['pipe_name']) ? $r['pipe_name'] : '',
                isset($r['work_zone']) ? $r['work_zone'] : '',
                isset($r['customer_type']) ? $r['customer_type'] : '',
                isset($r['reported_date']) ? $r['reported_date'] : '',
                isset($r['resolve_date']) ? $r['resolve_date'] : '',
                isset($r['ticket_status']) ? $r['ticket_status'] : '',
                isset($r['ttr_customer']) ? $r['ttr_customer'] : '',
                isset($r['summary']) ? $r['summary'] : ''
            ));
        }

        fclose($output);
        exit;
    }

    private function _sanitize_date($date_value) {
        if (empty($date_value)) return '';
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_value) !== 1) return '';
        $dt = DateTime::createFromFormat('Y-m-d', $date_value);
        if (!$dt || $dt->format('Y-m-d') !== $date_value) return '';
        return $date_value;
    }
}
