<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insera_model extends CI_Model {

    protected $db_db_lama;

    public function __construct() {
        parent::__construct();
        $this->db_db_lama = $this->load->database('db_lama', TRUE);
    }

    public function get_all() {
        $this->db_db_lama->where('deleted_at IS NULL');
        return $this->db_db_lama->get('insera')->result_array();
    }

    public function get_deleted() {
        $this->db_db_lama->where('deleted_at IS NOT NULL');
        $this->db_db_lama->order_by('deleted_at', 'DESC');
        return $this->db_db_lama->get('insera')->result_array();
    }

    public function get_insera($id) {
        $this->db_db_lama->where('ticket_id', $id);
        $this->db_db_lama->where('deleted_at IS NULL');
        return $this->db_db_lama->get('insera')->row_array();
    }

    public function get_insera_deleted($id) {
        $this->db_db_lama->where('ticket_id', $id);
        return $this->db_db_lama->get('insera')->row_array();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db_db_lama->insert('insera', $data);
        if ($result) {
            $insert_id = $this->db_db_lama->insert_id();
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'INSERA',
                'item_id'   => $insert_id,
                'item_name' => json_encode($data),
                'action'    => 'INSERT'
            ));
        }
        return $result;
    }

    public function update($id, $data) {
        $old_data = $this->get_insera($id);
        if (!$old_data) return FALSE;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db_db_lama->where('ticket_id', $id);
        $result = $this->db_db_lama->update('insera', $data);
        if ($result) {
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'INSERA',
                'item_id'   => $id,
                'item_name' => json_encode($data),
                'action'    => 'UPDATE',
                'before'    => $old_data,
                'after'     => $data
            ));
        }
        return $result;
    }

    public function delete($id) {
        $this->db_db_lama->where('ticket_id', $id);
        $result = $this->db_db_lama->update('insera', array('deleted_at' => date('Y-m-d H:i:s')));
        if ($result) {
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'INSERA',
                'item_id'   => $id,
                'item_name' => 'Soft Deleted',
                'action'    => 'DELETE'
            ));
        }
        return $result;
    }

    public function restore($id) {
        $this->db_db_lama->where('ticket_id', $id);
        return $this->db_db_lama->update('insera', array('deleted_at' => NULL));
    }

    public function hard_delete($id) {
        $this->db_db_lama->where('ticket_id', $id);
        return $this->db_db_lama->delete('insera');
    }

    public function insert_batch($data) {
        $result = $this->db_db_lama->insert_batch('insera', $data);
        if ($result) {
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'INSERA',
                'action'    => 'BATCH_INSERT',
                'item_name' => count($data) . ' Data Imported via Excel'
            ));
        }
        return $result;
    }
}
