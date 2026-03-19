<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_model extends CI_Model {

    public function get_all() {
        $this->db->where('deleted_at IS NULL');
        return $this->db->get('jabatan')->result_array();
    }

    public function get_deleted() {
        $this->db->where('deleted_at IS NOT NULL');
        $this->db->order_by('deleted_at', 'DESC');
        return $this->db->get('jabatan')->result_array();
    }

    public function get_jabatan($id) {
        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');
        return $this->db->get('jabatan')->row_array();
    }

    public function get_jabatan_deleted($id) {
        $this->db->where('id', $id);
        return $this->db->get('jabatan')->row_array();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert('jabatan', $data);
        if ($result) {
            $insert_id = $this->db->insert_id();
            $this->Log_model->write(array(
                'module'    => 'SYSTEM ADMINISTRATION',
                'sub_module'=> 'JABATAN',
                'item_id'   => $insert_id,
                'item_name' => $data['nama_jabatan'],
                'action'    => 'INSERT'
            ));
        }
        return $result;
    }

    public function update($id, $data) {
        $old_data = $this->get_jabatan($id);
        if (!$old_data) return FALSE;

        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $result = $this->db->update('jabatan', $data);
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM ADMINISTRATION',
                'sub_module'=> 'JABATAN',
                'item_id'   => $id,
                'item_name' => $data['nama_jabatan'],
                'action'    => 'UPDATE',
                'before'    => $old_data
            ));
        }
        return $result;
    }

    public function delete($id) {
        $data = $this->get_jabatan($id);
        if (!$data) return FALSE;

        $this->db->where('id', $id);
        $result = $this->db->update('jabatan', array('deleted_at' => date('Y-m-d H:i:s')));
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM ADMINISTRATION',
                'sub_module'=> 'JABATAN',
                'item_id'   => $id,
                'item_name' => $data['nama_jabatan'],
                'action'    => 'DELETE'
            ));
        }
        return $result;
    }

    public function restore($id) {
        $jabatan = $this->get_jabatan_deleted($id);
        if (!$jabatan) return FALSE;

        $this->db->where('id', $id);
        $result = $this->db->update('jabatan', array('deleted_at' => NULL));
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM ADMINISTRATION',
                'sub_module'=> 'JABATAN',
                'item_id'   => $id,
                'item_name' => $jabatan['nama_jabatan'],
                'action'    => 'RESTORE'
            ));
        }
        return $result;
    }

    public function hard_delete($id) {
        $jabatan = $this->get_jabatan_deleted($id);
        if (!$jabatan) return FALSE;

        $this->db->where('id', $id);
        $result = $this->db->delete('jabatan');
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM ADMINISTRATION',
                'sub_module'=> 'JABATAN',
                'item_id'   => $id,
                'item_name' => $jabatan['nama_jabatan'],
                'action'    => 'HARD_DELETE'
            ));
        }
        return $result;
    }
}
