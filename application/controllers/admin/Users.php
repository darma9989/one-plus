<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Controller — User Management
 */
class Users extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->model('Jabatan_model');
    }

    public function index() {
        $this->data['title'] = 'User Management';
        
        $is_superadmin = $this->session->userdata('is_superadmin');
        $can_view_all_users = $is_superadmin || $this->session->userdata('can_view_all_users') ? 1 : 0;
        $user_id = $can_view_all_users ? NULL : $this->session->userdata('user_id');

        $this->data['users'] = $this->User_model->get_all($user_id);
        $this->data['roles'] = $this->Role_model->get_all();
        $this->data['jabatan'] = $this->Jabatan_model->get_all();
        $this->data['can_add_user'] = $is_superadmin || $this->session->userdata('can_add_user') ? 1 : 0;
        
        // Statistics for Widgets
        $this->db->where('deleted_at IS NULL');
        if (!$can_view_all_users) $this->db->where('id', $user_id);
        $this->data['total_users'] = $this->db->count_all_results('users');
        
        $this->db->where('deleted_at IS NULL')->where('is_active', 1)->where('is_blocked', 0);
        if (!$can_view_all_users) $this->db->where('id', $user_id);
        $this->data['active_users'] = $this->db->count_all_results('users');
        
        $this->db->where('deleted_at IS NULL')->where('is_blocked', 1);
        if (!$can_view_all_users) $this->db->where('id', $user_id);
        $this->data['blocked_users'] = $this->db->count_all_results('users');

        $this->template->load('admin/users/index', $this->data);
    }

    private function _upload_avatar() {
        if (!empty($_FILES['avatar']['name'])) {
            $config['upload_path']   = './uploads/avatars/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['file_name']     = 'user_' . time();
            
            if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
            
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('avatar')) {
                $upload_data = $this->upload->data();
                return $upload_data['file_name'];
            }
        }
        return NULL;
    }

    public function add() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'message' => validation_errors()));
        } else {
            $data = array(
                'username'  => $this->input->post('username'),
                'nama'      => $this->input->post('nama'),
                'email'     => $this->input->post('email'),
                'no_telp'   => $this->input->post('no_telp'),
                'password'  => $this->input->post('password'),
                'role_id'   => $this->input->post('role_id'),
                'jabatan_id'=> $this->input->post('jabatan_id') ? $this->input->post('jabatan_id') : NULL,
                'workzone'  => $this->input->post('workzone') ? $this->input->post('workzone') : NULL,
                'is_active' => 1
            );
            
            $avatar = $this->_upload_avatar();
            if ($avatar) $data['avatar'] = $avatar;

            if ($this->User_model->insert($data)) {
                echo json_encode(array('status' => 'success', 'message' => 'User berhasil ditambahkan.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal menambahkan user.'));
            }
        }
    }

    public function get_user() {
        $id = $this->input->post('id');
        $user = $this->User_model->get_user($id);
        echo json_encode($user);
    }

    public function update() {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'message' => validation_errors()));
        } else {
            $data = array(
                'nama'      => $this->input->post('nama'),
                'email'     => $this->input->post('email'),
                'no_telp'   => $this->input->post('no_telp'),
                'role_id'   => $this->input->post('role_id'),
                'jabatan_id'=> $this->input->post('jabatan_id') ? $this->input->post('jabatan_id') : NULL,
                'workzone'  => $this->input->post('workzone') ? $this->input->post('workzone') : NULL,
                'is_active' => $this->input->post('is_active')
            );
            
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = $password;
            }
            
            $avatar = $this->_upload_avatar();
            if ($avatar) $data['avatar'] = $avatar;

            if ($this->User_model->update($id, $data)) {
                echo json_encode(array('status' => 'success', 'message' => 'User berhasil diupdate.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate user.'));
            }
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($this->User_model->delete($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'User berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus user.'));
        }
    }

    public function toggle_block() {
        $id = $this->input->post('id');
        if ($this->User_model->toggle_block($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Status user berhasil diubah.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengubah status.'));
        }
    }

    public function reset_password() {
        $id = $this->input->post('id');
        $new_password = $this->input->post('new_password');
        if ($this->User_model->reset_password($id, $new_password)) {
            echo json_encode(array('status' => 'success', 'message' => 'Password berhasil direset.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mereset password.'));
        }
    }

    public function restore() {
        $id = $this->input->post('id');
        if ($this->User_model->restore($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'User berhasil dikembalikan.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengembalikan user.'));
        }
    }

    public function get_deleted() {
        $is_superadmin = $this->session->userdata('is_superadmin');
        $can_view_all_users = $is_superadmin || $this->session->userdata('can_view_all_users') ? 1 : 0;
        $user_id = $can_view_all_users ? NULL : $this->session->userdata('user_id');

        $data = $this->User_model->get_deleted($user_id);
        echo json_encode($data);
    }
}
