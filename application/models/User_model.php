<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model — User Management CRUD
 */
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all($user_id = NULL) {
        $this->db->select('u.*, r.role_name, j.nama_jabatan, u.workzone');
        $this->db->from('users u');
        $this->db->join('roles r', 'u.role_id = r.id', 'left');
        $this->db->join('jabatan j', 'u.jabatan_id = j.id', 'left');
        $this->db->where('u.deleted_at IS NULL');
        
        if ($user_id !== NULL) {
            $this->db->where('u.id', $user_id);
        }
        
        $this->db->order_by('u.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_user($id) {
        $this->db->select('u.*, r.role_name, j.nama_jabatan, u.workzone');
        $this->db->from('users u');
        $this->db->join('roles r', 'u.role_id = r.id', 'left');
        $this->db->join('jabatan j', 'u.jabatan_id = j.id', 'left');
        $this->db->where('u.id', $id);
        return $this->db->get()->row_array();
    }

    public function insert($data) {
        $data['password'] = md5($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->db->insert('users', $data);
        if ($result) {
            $log_data = $data;
            unset($log_data['password']);
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $this->db->insert_id(),
                'item_name' => $data['nama'],
                'action'    => 'CREATE',
                'after'     => $log_data
            ));
        }
        return $result;
    }

    public function update($id, $data) {
        $old_data = $this->get_user($id);
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = md5($data['password']);
        } else {
            unset($data['password']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $result = $this->db->update('users', $data);
        if ($result) {
            $log_data = $data;
            unset($log_data['password']);
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $id,
                'item_name' => $old_data['nama'],
                'action'    => 'UPDATE',
                'before'    => $old_data,
                'after'     => $log_data
            ));
        }
        return $result;
    }

    public function delete($id) {
        $old_data = $this->get_user($id);
        // Soft delete
        $this->db->where('id', $id);
        $result = $this->db->update('users', array('deleted_at' => date('Y-m-d H:i:s')));
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $id,
                'item_name' => $old_data['nama'],
                'action'    => 'DELETE',
                'before'    => $old_data
            ));
        }
        return $result;
    }

    public function get_deleted($user_id = NULL) {
        $this->db->select('u.*, r.role_name, j.nama_jabatan, u.workzone');
        $this->db->from('users u');
        $this->db->join('roles r', 'u.role_id = r.id', 'left');
        $this->db->join('jabatan j', 'u.jabatan_id = j.id', 'left');
        $this->db->where('u.deleted_at IS NOT NULL');
        
        if ($user_id !== NULL) {
            $this->db->where('u.id', $user_id);
        }
        
        $this->db->order_by('u.deleted_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function restore($id) {
        $user = $this->get_user_deleted($id);
        $this->db->where('id', $id);
        $result = $this->db->update('users', array('deleted_at' => NULL));
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $id,
                'item_name' => $user['nama'],
                'action'    => 'RESTORE'
            ));
        }
        return $result;
    }

    public function get_user_deleted($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row_array();
    }

    public function toggle_block($id) {
        $user = $this->get_user($id);
        $new_status = ($user['is_blocked'] == 1) ? 0 : 1;
        $this->db->where('id', $id);
        $result = $this->db->update('users', array(
            'is_blocked'   => $new_status,
            'failed_login' => 0,
            'updated_at'   => date('Y-m-d H:i:s')
        ));
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $id,
                'item_name' => $user['nama'],
                'action'    => $new_status ? 'BLOCK' : 'UNBLOCK'
            ));
        }
        return $result;
    }

    public function reset_password($id, $new_password) {
        $user = $this->get_user($id);
        $this->db->where('id', $id);
        $result = $this->db->update('users', array(
            'password'     => md5($new_password),
            'failed_login' => 0,
            'is_blocked'   => 0,
            'updated_at'   => date('Y-m-d H:i:s')
        ));
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $id,
                'item_name' => $user['nama'],
                'action'    => 'PASSWORD_RESET'
            ));
        }
        return $result;
    }

    public function count_all() {
        return $this->db->where('deleted_at IS NULL')->count_all_results('users');
    }
    public function hard_delete($id) {
        $user = $this->get_user_deleted($id);
        if ($id == 1 || !$user) return FALSE; // Prevent deleting superadmin root
        
        $this->db->where('id', $id);
        $result = $this->db->delete('users');
        if ($result) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'USERS',
                'item_id'   => $id,
                'item_name' => $user['nama'],
                'action'    => 'HARD_DELETE'
            ));
        }
        return $result;
    }
}
