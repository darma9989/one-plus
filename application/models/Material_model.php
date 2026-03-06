<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material_model extends CI_Model {

    protected $db_db_lama;

    public function __construct() {
        parent::__construct();
        $this->db_db_lama = $this->load->database('db_lama', TRUE);
    }

    public function get_all() {
        $this->db_db_lama->where('deleted_at IS NULL');
        return $this->db_db_lama->get('listmaterialwh')->result_array();
    }

    public function get_deleted() {
        $this->db_db_lama->where('deleted_at IS NOT NULL');
        $this->db_db_lama->order_by('deleted_at', 'DESC');
        return $this->db_db_lama->get('listmaterialwh')->result_array();
    }

    public function get_material($id) {
        $this->db_db_lama->where('id_list_material_wh', $id);
        $this->db_db_lama->where('deleted_at IS NULL');
        return $this->db_db_lama->get('listmaterialwh')->row_array();
    }

    public function get_material_deleted($id) {
        $this->db_db_lama->where('id_list_material_wh', $id);
        return $this->db_db_lama->get('listmaterialwh')->row_array();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db_db_lama->insert('listmaterialwh', $data);
        if ($result) {
            $insert_id = $this->db_db_lama->insert_id();
            $this->load->model('Log_model');
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'MATERIAL',
                'item_id'   => $insert_id,
                'item_name' => json_encode($data),
                'action'    => 'INSERT'
            ));
        }
        return $result;
    }

    public function update($id, $data) {
        $old_data = $this->get_material($id);
        if (!$old_data) return FALSE;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db_db_lama->where('id_list_material_wh', $id);
        $result = $this->db_db_lama->update('listmaterialwh', $data);
        if ($result) {
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'MATERIAL',
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
        $this->db_db_lama->where('id_list_material_wh', $id);
        $result = $this->db_db_lama->update('listmaterialwh', array('deleted_at' => date('Y-m-d H:i:s')));
        if ($result) {
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'MATERIAL',
                'item_id'   => $id,
                'item_name' => 'Soft Deleted',
                'action'    => 'DELETE'
            ));
        }
        return $result;
    }

    public function restore($id) {
        $this->db_db_lama->where('id_list_material_wh', $id);
        return $this->db_db_lama->update('listmaterialwh', array('deleted_at' => NULL));
    }

    public function hard_delete($id) {
        $this->db_db_lama->where('id_list_material_wh', $id);
        return $this->db_db_lama->delete('listmaterialwh');
    }

    public function insert_batch($data) {
        $result = $this->db_db_lama->insert_batch('listmaterialwh', $data);
        if ($result) {
            $this->load->model('Log_model');
            $this->Log_model->write(array(
                'module'    => 'MASTER DATA',
                'sub_module'=> 'MATERIAL',
                'action'    => 'BATCH_INSERT',
                'item_name' => count($data) . ' Data Imported via Excel'
            ));
        }
        return $result;
    }
}
