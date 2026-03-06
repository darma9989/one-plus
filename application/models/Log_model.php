<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Log_model — Activity Log Engine
 */
class Log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Tulis log aktivitas
     * @param array $params (module, sub_module, item_id, item_name, action, before, after)
     */
    public function write($params) {
        $log_data = array(
            'module'      => isset($params['module']) ? strtoupper($params['module']) : 'SYSTEM',
            'sub_module'  => isset($params['sub_module']) ? strtoupper($params['sub_module']) : NULL,
            'item_id'     => isset($params['item_id']) ? $params['item_id'] : NULL,
            'item_name'   => isset($params['item_name']) ? $params['item_name'] : NULL,
            'action'      => isset($params['action']) ? strtoupper($params['action']) : 'UPDATE',
            'data_before' => isset($params['before']) ? (is_array($params['before']) ? json_encode($params['before']) : $params['before']) : NULL,
            'data_after'  => isset($params['after']) ? (is_array($params['after']) ? json_encode($params['after']) : $params['after']) : NULL,
            'user_id'     => $this->session->userdata('user_id'),
            'user_name'   => $this->session->userdata('nama'),
            'ip_address'  => $this->input->ip_address(),
            'user_agent'  => $this->input->user_agent(),
            'created_at'  => date('Y-m-d H:i:s')
        );

        return $this->db->insert('activity_logs', $log_data);
    }

    /**
     * Ambil log dengan filter
     */
    public function get_logs($filters = array(), $limit = 100, $offset = 0) {
        if (isset($filters['module'])) $this->db->where('module', strtoupper($filters['module']));
        if (isset($filters['sub_module'])) $this->db->where('sub_module', strtoupper($filters['sub_module']));
        if (isset($filters['item_id'])) $this->db->where('item_id', $filters['item_id']);
        if (isset($filters['action'])) $this->db->where('action', strtoupper($filters['action']));
        if (isset($filters['user_id'])) $this->db->where('user_id', $filters['user_id']);
        if (isset($filters['date_from'])) $this->db->where('created_at >=', $filters['date_from']);
        if (isset($filters['date_to'])) $this->db->where('created_at <=', $filters['date_to'] . ' 23:59:59');

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('activity_logs')->result_array();
    }

    /**
     * Ambil detail log by ID
     */
    public function get_log($id) {
        return $this->db->get_where('activity_logs', array('id' => $id))->row();
    }

    /**
     * Hitung total log (untuk pagination)
     */
    public function count_logs($filters = array()) {
        if (isset($filters['module'])) $this->db->where('module', strtoupper($filters['module']));
        if (isset($filters['action'])) $this->db->where('action', strtoupper($filters['action']));
        if (isset($filters['user_id'])) $this->db->where('user_id', $filters['user_id']);
        return $this->db->count_all_results('activity_logs');
    }

    /**
     * Ambil daftar module unik (untuk dropdown filter)
     */
    public function get_modules() {
        $this->db->select('DISTINCT(module) as module');
        $this->db->order_by('module', 'ASC');
        return $this->db->get('activity_logs')->result_array();
    }
}
