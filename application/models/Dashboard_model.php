<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_widgets() {
        $this->db->where('is_active', 1);
        $this->db->order_by('order_num', 'ASC');
        return $this->db->get('dashboard_widgets')->result_array();
    }

    public function get_all_widgets_management() {
        $this->db->order_by('order_num', 'ASC');
        return $this->db->get('dashboard_widgets')->result_array();
    }

    public function get_stat_value($widget) {
        $table = $widget['table_source'];
        $field = $widget['calc_field'];
        $type = $widget['calc_type'];

        if (!$this->db->table_exists($table)) return 0;

        if ($this->db->field_exists('deleted_at', $table)) {
            $this->db->where('deleted_at IS NULL');
        }
        
        if ($type == 'COUNT') {
            return $this->db->count_all_results($table);
        } elseif ($type == 'SUM') {
            $this->db->select_sum($field);
            $res = $this->db->get($table)->row_array();
            return isset($res[$field]) ? $res[$field] : 0;
        } elseif ($type == 'AVG') {
            $this->db->select_avg($field);
            $res = $this->db->get($table)->row_array();
            return isset($res[$field]) ? round($res[$field], 2) : 0;
        }
        return 0;
    }

    public function get_chart_data($widget) {
        $table = $widget['table_source'];
        if (!$this->db->table_exists($table)) return [];

        if ($widget['type'] == 'line_chart') {
            // Trend per bulan (last 6 months)
            $deleted_condition = $this->db->field_exists('deleted_at', $table) ? "AND deleted_at IS NULL" : "";
            $query = "SELECT 
                        DATE_FORMAT(created_at, '%M') as label, 
                        COUNT(id) as value 
                      FROM $table 
                      WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH) 
                        $deleted_condition
                      GROUP BY MONTH(created_at) 
                      ORDER BY created_at ASC";
            return $this->db->query($query)->result_array();
        } elseif ($widget['type'] == 'pie_chart') {
            // Distribusi berdasar field tertentu (heuristik: cari field status atau role_id)
            $group_field = $widget['calc_field'];
            if (!$this->db->field_exists($group_field, $table)) return [];

            $this->db->select("$group_field as label, COUNT(*) as value");
            if ($this->db->field_exists('deleted_at', $table)) {
                $this->db->where('deleted_at IS NULL');
            }
            $this->db->group_by($group_field);
            return $this->db->get($table)->result_array();
        }
        return [];
    }

    public function get_recent_list($widget) {
        $table = $widget['table_source'];
        if (!$this->db->table_exists($table)) return [];

        if ($this->db->field_exists('deleted_at', $table)) {
            $this->db->where('deleted_at IS NULL');
        }
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(5);
        $res = $this->db->get($table)->result_array();

        // Heuristik untuk label
        foreach ($res as &$row) {
            $row['_main'] = isset($row['nama']) ? $row['nama'] : (isset($row['username']) ? $row['username'] : (isset($row['title']) ? $row['title'] : 'Item #'.$row['id']));
        }
        return $res;
    }

    public function get_pivot_data($widget) {
        $table = $widget['table_source'];
        $group_field = $widget['calc_field'];
        $calc_type = $widget['calc_type'];

        if (!$this->db->table_exists($table)) return [];
        if (!$this->db->field_exists($group_field, $table)) return [];

        $select_dim = "$table.$group_field as dimension";
        
        // Relational Heuristics (Point 2)
        if (substr($group_field, -3) === '_id') {
            $ref_table = substr($group_field, 0, -3);
            if ($this->db->table_exists($ref_table . 's')) $ref_table = $ref_table . 's'; 
            elseif ($this->db->table_exists($ref_table)) $ref_table = $ref_table; 
            else $ref_table = false;
            
            if ($ref_table) {
                // Find label column
                $ref_fields = $this->db->list_fields($ref_table);
                $label_col = '';
                foreach (array('nama', 'name', 'title', 'role_name', 'nama_'.$ref_table, 'username') as $f) {
                    if (in_array($f, $ref_fields)) { $label_col = $f; break; }
                }
                
                if ($label_col) {
                    $select_dim = "COALESCE($ref_table.$label_col, $table.$group_field) as dimension";
                    $this->db->join($ref_table, "$ref_table.id = $table.$group_field", 'left');
                }
            }
        }

        if ($calc_type == 'COUNT') {
            $this->db->select("$select_dim, COUNT($table.id) as total");
        } elseif ($calc_type == 'SUM') {
            $this->db->select("$select_dim, SUM($table.id) as total"); 
        }

        if ($this->db->field_exists('deleted_at', $table)) {
            $this->db->where("$table.deleted_at IS NULL");
        }
        $this->db->group_by("$table.$group_field");
        $this->db->order_by('total', 'DESC');
        return $this->db->get($table)->result_array();
    }

    public function save($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('dashboard_widgets', $data);
        } else {
            return $this->db->insert('dashboard_widgets', $data);
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('dashboard_widgets');
    }
}
