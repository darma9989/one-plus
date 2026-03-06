<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_generator_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_tables($db_group = 'default') {
        if ($db_group != 'default') {
            $db = $this->load->database($db_group, TRUE);
            $db->db_debug = FALSE;
            $tables = $db->list_tables();
        } else {
            $tables = $this->db->list_tables();
        }
        $ignore = ['activity_logs', 'menu', 'role_permissions', 'roles', 'users', 'ci_sessions'];
        $result = [];
        if ($tables) {
            foreach ($tables as $t) {
                if (!in_array($t, $ignore)) {
                    $result[] = $t;
                }
            }
        }
        return $result;
    }

    public function get_fields($table, $db_group = 'default') {
        if ($db_group != 'default') {
            $db = $this->load->database($db_group, TRUE);
            $db->db_debug = FALSE;
            return $db->field_data($table);
        } else {
            return $this->db->field_data($table);
        }
    }

    public function get_parents() {
        $this->db->where('parent_id IS NULL');
        $this->db->order_by('menu_order', 'ASC');
        return $this->db->get('menu')->result_array();
    }

    public function create_table($table_name, $fields_raw) {
        $this->load->dbforge();

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            )
        );

        foreach ($fields_raw as $f) {
            $f_name = $f['name'];
            $f_type = strtoupper($f['type']);
            
            $field_def = array('type' => $f_type);
            if (!empty($f['length']) && in_array($f_type, ['VARCHAR', 'INT', 'CHAR'])) {
                $field_def['constraint'] = $f['length'];
            }
            if (!empty($f['null'])) {
                $field_def['null'] = TRUE;
            } else {
                $field_def['null'] = FALSE;
            }
            $fields[$f_name] = $field_def;
        }

        $fields['created_at'] = array('type' => 'DATETIME', 'null' => TRUE);
        $fields['updated_at'] = array('type' => 'DATETIME', 'null' => TRUE);
        $fields['deleted_at'] = array('type' => 'DATETIME', 'null' => TRUE);

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        
        return $this->dbforge->create_table($table_name, TRUE);
    }
}
