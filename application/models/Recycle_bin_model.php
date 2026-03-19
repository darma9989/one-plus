<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recycle_bin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Log_model');
    }

    protected function _get_db($table) {
        if ($this->db->table_exists($table) && $this->db->field_exists('deleted_at', $table)) {
            return $this->db;
        }
        $db_lama = $this->load->database('db_lama', TRUE);
        if ($db_lama && !empty($db_lama->conn_id) && $db_lama->table_exists($table)) {
            return $db_lama;
        }
        return $this->db; // fallback
    }

    protected function _get_pk_name($db, $table) {
        $fields = $db->field_data($table);
        foreach ($fields as $f) {
            if (isset($f->primary_key) && $f->primary_key == 1) return $f->name;
        }
        foreach ($fields as $f) {
            if (strtolower($f->name) === 'id') return $f->name;
        }
        return $fields[0]->name;
    }

    public function get_vault_tables() {
        $vault = [];
        $ignore = ['activity_logs', 'role_permissions'];

        $tables = $this->db->list_tables();
        foreach ($tables as $t) {
            if (in_array($t, $ignore)) continue;
            if ($this->db->field_exists('deleted_at', $t)) {
                $vault[] = $t;
            }
        }

        // Hook ke legacy database (db_lama) jika menyala
        $db_lama = $this->load->database('db_lama', TRUE);
        if ($db_lama && !empty($db_lama->conn_id)) {
            $lama_tables = $db_lama->list_tables();
            foreach ($lama_tables as $t) {
                if (in_array($t, $ignore)) continue;
                if (!in_array($t, $vault) && $db_lama->field_exists('deleted_at', $t)) {
                    $vault[] = $t;
                }
            }
        }

        return $vault;
    }

    public function get_deleted_count($table) {
        $db = $this->_get_db($table);
        $db->where('deleted_at IS NOT NULL');
        return $db->count_all_results($table);
    }

    public function get_deleted_data($table) {
        $db = $this->_get_db($table);
        $pk = $this->_get_pk_name($db, $table);
        
        $db->where('deleted_at IS NOT NULL');
        $db->order_by('deleted_at', 'DESC');
        $results = $db->get($table)->result_array();
        
        $fields = $db->list_fields($table);
        
        $mapped = [];
        foreach ($results as $row) {
            $pk_val = isset($row[$pk]) ? $row[$pk] : (isset($row['id']) ? $row['id'] : array_values($row)[0]);
            $identifier = 'Item #' . $pk_val;
            $description = '';
            
            // Heuristics for item main name
            if (isset($row['nama'])) $identifier = $row['nama'];
            elseif (isset($row['nama_material'])) $identifier = $row['nama_material'];
            elseif (isset($row['menu_name'])) $identifier = $row['menu_name'];
            elseif (isset($row['role_name'])) $identifier = $row['role_name'];
            elseif (isset($row['nama_jabatan'])) $identifier = $row['nama_jabatan'];
            else {
                foreach ($fields as $f) {
                    if (!in_array($f, [$pk, 'id', 'created_at', 'updated_at', 'deleted_at', 'password', 'avatar', 'is_active'])) {
                        if (is_string($row[$f]) && !is_numeric($row[$f])) {
                            $identifier = $row[$f];
                            break;
                        }
                    }
                }
            }

            // Heuristics for item sub
            if (isset($row['description'])) $description = $row['description'];
            elseif (isset($row['deskripsi'])) $description = $row['deskripsi'];
            elseif (isset($row['designator'])) $description = 'Designator: ' . $row['designator'];
            elseif (isset($row['menu_link'])) $description = $row['menu_link'];
            elseif (isset($row['username'])) $description = 'Username: ' . $row['username'];
            
            $row['_type'] = $table;
            $row['_main'] = $identifier;
            $row['_sub'] = $description;
            $row['_pk_id'] = $pk_val; // simpan referensi ID spesifik
            
            $mapped[] = $row;
        }
        return $mapped;
    }

    public function restore($table, $id) {
        $allowed = $this->get_vault_tables();
        if (!in_array($table, $allowed)) return FALSE;

        $db = $this->_get_db($table);
        $pk = $this->_get_pk_name($db, $table);

        $db->where($pk, $id);
        $result = $db->update($table, array('deleted_at' => NULL));

        if ($result) {
            $this->Log_model->write(array(
                'module'    => strtoupper($table),
                'sub_module'=> 'RECYCLE_BIN',
                'item_id'   => $id,
                'item_name' => 'Data Restored (' . $pk . ': ' . $id . ')',
                'action'    => 'UPDATE'
            ));
        }
        return $result;
    }

    public function hard_delete($table, $id) {
        $allowed = $this->get_vault_tables();
        if (!in_array($table, $allowed)) return FALSE;

        $db = $this->_get_db($table);
        $pk = $this->_get_pk_name($db, $table);

        // Proteksi System Root
        if ($table == 'users' && $id == 1) return FALSE;
        if ($table == 'roles' && $id == 1) return FALSE;

        $db->where($pk, $id);
        $result = $db->delete($table);

        if ($result) {
            $this->Log_model->write(array(
                'module'    => strtoupper($table),
                'sub_module'=> 'RECYCLE_BIN',
                'item_id'   => $id,
                'item_name' => 'Permanent Delete',
                'action'    => 'DELETE'
            ));
        }
        return $result;
    }

    public function empty_bin() {
        $tables = $this->get_vault_tables();
        $this->db->trans_start();

        foreach ($tables as $table) {
            $db = $this->_get_db($table);
            $pk = $this->_get_pk_name($db, $table);

            $db->where('deleted_at IS NOT NULL');
            if ($table == 'users' || $table == 'roles') {
                $db->where($pk . ' !=', 1);
            }
            $db->delete($table);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() !== FALSE) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'RECYCLE_BIN',
                'action'    => 'DELETE',
                'item_name' => 'Empty All Recycle Bin'
            ));
            return TRUE;
        }
        return FALSE;
    }
}
