<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Setting_model — System Configuration (key-value)
 */
class Setting_model extends CI_Model {

    private $cache = array();

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil setting berdasarkan key
     */
    public function get($key) {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        $row = $this->db->get_where('settings', array('setting_key' => $key))->row();
        if ($row) {
            $this->cache[$key] = $row->setting_value;
            return $row->setting_value;
        }
        return NULL;
    }

    /**
     * Simpan / update setting
     */
    public function set($key, $value) {
        $existing = $this->db->get_where('settings', array('setting_key' => $key))->row();
        if ($existing) {
            $this->db->where('setting_key', $key);
            $result = $this->db->update('settings', array(
                'setting_value' => $value,
                'updated_at'    => date('Y-m-d H:i:s')
            ));
        } else {
            $result = $this->db->insert('settings', array(
                'setting_key'   => $key,
                'setting_value' => $value,
                'updated_at'    => date('Y-m-d H:i:s')
            ));
        }
        $this->cache[$key] = $value;
        return $result;
    }

    /**
     * Ambil semua settings sebagai associative array
     */
    public function get_all() {
        if (!empty($this->cache)) {
            return $this->cache;
        }
        $query = $this->db->get('settings');
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->setting_key] = $row->setting_value;
            $this->cache[$row->setting_key] = $row->setting_value;
        }
        return $result;
    }

    /**
     * Ambil settings berdasarkan group
     */
    public function get_by_group($group) {
        $this->db->where('setting_group', $group);
        $query = $this->db->get('settings');
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->setting_key] = $row->setting_value;
        }
        return $result;
    }

    /**
     * Update multiple settings sekaligus
     */
    public function save_batch($data) {
        $this->db->trans_start();
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
