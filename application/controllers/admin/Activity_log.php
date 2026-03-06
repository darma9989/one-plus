<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['title'] = 'Activity Log';
        $this->data['modules'] = $this->Log_model->get_modules();
        $this->template->load('admin/activity_log/index', $this->data);
    }

    public function get_datatable() {
        $draw   = intval($this->input->post('draw'));
        $start  = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search');
        $search_value = isset($search['value']) ? $search['value'] : '';

        $module = $this->input->post('module_filter');
        $action = $this->input->post('action_filter');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $this->db->from('activity_logs');
        if ($module) $this->db->where('module', $module);
        if ($action) $this->db->where('action', $action);
        if ($date_from) $this->db->where('created_at >=', $date_from . ' 00:00:00');
        if ($date_to) $this->db->where('created_at <=', $date_to . ' 23:59:59');
        if ($search_value) {
            $this->db->group_start();
            $this->db->like('item_name', $search_value);
            $this->db->or_like('user_name', $search_value);
            $this->db->or_like('module', $search_value);
            $this->db->group_end();
        }
        $total = $this->db->count_all_results('', FALSE);

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($length, $start);
        $logs = $this->db->get()->result();

        $data = array();
        foreach ($logs as $log) {
            $badge = '<span class="label label-default">' . $log->action . '</span>';
            if ($log->action == 'CREATE') $badge = '<span class="label label-success">CREATE</span>';
            elseif ($log->action == 'UPDATE') $badge = '<span class="label label-primary">UPDATE</span>';
            elseif ($log->action == 'DELETE') $badge = '<span class="label label-danger">DELETE</span>';
            elseif ($log->action == 'LOGIN') $badge = '<span class="label label-info">LOGIN</span>';
            elseif ($log->action == 'LOGOUT') $badge = '<span class="label label-warning">LOGOUT</span>';

            $data[] = array(
                date('d/m/Y H:i:s', strtotime($log->created_at)),
                '<strong>' . $log->module . '</strong>' . ($log->sub_module ? '<br><small>' . $log->sub_module . '</small>' : ''),
                $log->item_name ? $log->item_name : '<small class="text-muted">-</small>',
                $badge,
                '<strong>' . ($log->user_name ? $log->user_name : 'System') . '</strong><br><small>' . $log->ip_address . '</small>',
                '<button class="btn btn-xs btn-info btn-detail" data-id="' . $log->id . '"><i class="fa fa-eye"></i></button>'
            );
        }

        echo json_encode(array(
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data
        ));
    }

    public function get_detail() {
        $id = $this->input->get_post('id');
        $log = $this->Log_model->get_log($id);
        if ($log) {
            $log->data_before = json_decode($log->data_before, TRUE);
            $log->data_after = json_decode($log->data_after, TRUE);
        }
        echo json_encode($log);
    }
}
