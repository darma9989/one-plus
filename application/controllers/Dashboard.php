<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 */
class Dashboard extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $this->data['title'] = 'Dashboard';
        
        // Load Dynamic Widgets
        $widgets = $this->Dashboard_model->get_widgets();
        foreach ($widgets as &$w) {
            if ($w['type'] == 'stat_box') {
                $w['value'] = $this->Dashboard_model->get_stat_value($w);
            } elseif ($w['type'] == 'line_chart' || $w['type'] == 'pie_chart') {
                $w['chart_data'] = $this->Dashboard_model->get_chart_data($w);
            } elseif ($w['type'] == 'recent_list') {
                $w['list_data'] = $this->Dashboard_model->get_recent_list($w);
            } elseif ($w['type'] == 'pivot_table') {
                $w['pivot_data'] = $this->Dashboard_model->get_pivot_data($w);
            }
        }
        $this->data['widgets'] = $widgets;

        // Recent logs (Global Audit)
        $this->data['recent_logs'] = $this->Log_model->get_logs(array(), 10);

        // System Health Info (Static Diagnostics)
        $this->data['sys_health'] = array(
            'php_version' => PHP_VERSION,
            'mysql_version' => $this->db->version(),
            'memory_usage' => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
            'upload_path' => './uploads/',
            'is_writeable' => is_really_writable('./uploads/'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize')
        );

        $this->template->load('admin/dashboard/index', $this->data);
    }
}
