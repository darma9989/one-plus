<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Role_model — Multi-role RBAC Dinamis
 */
class Role_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('id', 'ASC');
        return $this->db->get('roles')->result_array();
    }

    public function get_role($id) {
        return $this->db->get_where('roles', array('id' => $id, 'deleted_at' => NULL))->row_array();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert('roles', $data);
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'ROLES',
                'item_id'   => $this->db->insert_id(),
                'item_name' => $data['role_name'],
                'action'    => 'CREATE',
                'after'     => $data
            ));
        }
        return $result;
    }

    public function update($id, $data) {
        $old_data = $this->get_role($id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $result = $this->db->update('roles', $data);
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'ROLES',
                'item_id'   => $id,
                'item_name' => $old_data['role_name'],
                'action'    => 'UPDATE',
                'before'    => $old_data,
                'after'     => $data
            ));
        }
        return $result;
    }

    public function delete($id) {
        $old_data = $this->get_role($id);
        // Jangan hapus role superadmin
        if ($old_data && $old_data['is_superadmin'] == 1) {
            return FALSE;
        }
        
        $data = array('deleted_at' => date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $result = $this->db->update('roles', $data);
        
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'ROLES',
                'item_id'   => $id,
                'item_name' => $old_data['role_name'],
                'action'    => 'DELETE',
                'before'    => $old_data
            ));
        }
        return $result;
    }

    public function count_users($role_id) {
        return $this->db->where('role_id', $role_id)->where('deleted_at IS NULL')->count_all_results('users');
    }

    public function get_deleted() {
        $this->db->where('deleted_at IS NOT NULL');
        $this->db->order_by('deleted_at', 'DESC');
        return $this->db->get('roles')->result_array();
    }

    public function restore($id) {
        $this->db->where('id', $id);
        $result = $this->db->update('roles', array('deleted_at' => NULL));
        if ($result) {
            $role = $this->db->get_where('roles', array('id' => $id))->row_array();
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'ROLES',
                'item_id'   => $id,
                'item_name' => $role['role_name'],
                'action'    => 'RESTORE'
            ));
        }
        return $result;
    }
    public function hard_delete($id) {
        $role = $this->db->get_where('roles', array('id' => $id))->row_array();
        if ($id == 1 || !$role) return FALSE; // Prevent deleting superadmin root
        
        $this->db->where('id', $id);
        $result = $this->db->delete('roles');
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'ROLES',
                'item_id'   => $id,
                'item_name' => $role['role_name'],
                'action'    => 'HARD_DELETE'
            ));
        }
        return $result;
    }
}
