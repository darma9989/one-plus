<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $this->data['title'] = 'My Profile';
        $this->data['user'] = $this->User_model->get_user($user_id);
        $this->template->load('admin/profile/index', $this->data);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'nama'     => $this->input->post('nama'),
            'username' => $this->input->post('username')
        );

        if ($this->User_model->update($user_id, $data)) {
            // Update session data
            $this->session->set_userdata('nama', $data['nama']);
            echo json_encode(array('status' => 'success', 'message' => 'Profil berhasil diperbarui.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal memperbarui profil.'));
        }
    }

    public function update_password() {
        $user_id = $this->session->userdata('user_id');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        $user = $this->User_model->get_user($user_id);

        if (md5($old_password) !== $user['password']) {
            echo json_encode(array('status' => 'error', 'message' => 'Password lama salah.'));
            return;
        }

        if ($new_password !== $confirm_password) {
            echo json_encode(array('status' => 'error', 'message' => 'Konfirmasi password tidak cocok.'));
            return;
        }

        if ($this->User_model->update($user_id, array('password' => md5($new_password)))) {
            echo json_encode(array('status' => 'success', 'message' => 'Password berhasil diubah.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengubah password.'));
        }
    }

    public function update_avatar() {
        $user_id = $this->session->userdata('user_id');
        
        $config['upload_path']   = './uploads/avatars/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'avatar-' . $user_id . '-' . time();
        $config['overwrite']     = TRUE;

        // Ensure directory exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('avatar')) {
            echo json_encode(array('status' => 'error', 'message' => $this->upload->display_errors('', '')));
        } else {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];

            // Delete old avatar if not default
            $user = $this->User_model->get_user($user_id);
            if ($user['avatar'] != 'default.png' && file_exists('./uploads/avatars/' . $user['avatar'])) {
                @unlink('./uploads/avatars/' . $user['avatar']);
            }

            if ($this->User_model->update($user_id, array('avatar' => $filename))) {
                $this->session->set_userdata('avatar', $filename);
                echo json_encode(array('status' => 'success', 'message' => 'Avatar berhasil diperbarui.', 'filename' => $filename));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal update database.'));
            }
        }
    }
}
