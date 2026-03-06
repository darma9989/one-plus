<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth_model — Authentication Engine
 */
class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Proses login
     */
    public function login($username, $password, $remember_me = FALSE) {
        $user = $this->db->select('u.*, r.role_name, r.is_superadmin, r.can_add_user, r.can_view_all_users')
                         ->from('users u')
                         ->join('roles r', 'u.role_id = r.id', 'left')
                         ->where('u.username', $username)
                         ->where('u.deleted_at IS NULL')
                         ->get()
                         ->row_array();

        if (!$user) {
            $this->Log_model->write(array(
                'module' => 'AUTH',
                'action' => 'LOGIN_FAILED',
                'after'  => array('reason' => 'User not found', 'username' => $username)
            ));
            return array('status' => FALSE, 'message' => 'Username atau Password salah.');
        }

        // Cek user aktif
        if ($user['is_active'] != 1) {
            return array('status' => FALSE, 'message' => 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Cek user diblokir
        if ($user['is_blocked'] == 1) {
            return array('status' => FALSE, 'message' => 'Akun Anda terkunci! Hubungi administrator.');
        }

        // Verifikasi password (MD5)
        if (md5($password) !== $user['password']) {
            // Increment failed login
            $max_attempts = $this->Setting_model->get('login_attempts');
            $max_attempts = $max_attempts ? intval($max_attempts) : 3;
            $new_failed = $user['failed_login'] + 1;

            $update_data = array('failed_login' => $new_failed);
            if ($new_failed >= $max_attempts) {
                $update_data['is_blocked'] = 1;
            }

            $this->db->where('id', $user['id'])->update('users', $update_data);

            $this->Log_model->write(array(
                'module'    => 'AUTH',
                'item_id'   => $user['id'],
                'item_name' => $user['nama'],
                'action'    => 'LOGIN_FAILED',
                'after'     => array('reason' => 'Wrong password', 'attempt' => $new_failed)
            ));

            $sisa = $max_attempts - $new_failed;
            if ($new_failed >= $max_attempts) {
                return array('status' => FALSE, 'message' => 'Akun Anda terkunci karena terlalu banyak percobaan login gagal.');
            }
            return array('status' => FALSE, 'message' => 'Password salah. Sisa kesempatan: ' . $sisa);
        }

        // === LOGIN BERHASIL ===

        // Reset failed login counter
        $this->db->where('id', $user['id'])->update('users', array(
            'failed_login' => 0,
            'last_login'   => date('Y-m-d H:i:s')
        ));

        // Remember me logic
        if ($remember_me) {
            $token = bin2hex(openssl_random_pseudo_bytes(32)); // Generate secure random token (PHP 5.6 compatible)
            $this->load->helper('cookie');
            // Set cookie for 30 days
            set_cookie('remember_token', $token, 30 * 24 * 60 * 60);
            
            // Save token to DB
            $this->db->where('id', $user['id'])->update('users', array('remember_token' => $token));
        }

        // Set session
        $this->session->set_userdata(array(
            'is_logged_in' => TRUE,
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'nama'         => $user['nama'],
            'email'        => $user['email'],
            'avatar'       => $user['avatar'],
            'role_id'      => $user['role_id'],
            'role_name'    => $user['role_name'],
            'is_superadmin'=> $user['is_superadmin'],
            'can_add_user' => $user['can_add_user'],
            'can_view_all_users' => $user['can_view_all_users']
        ));

        // Audit log
        $this->Log_model->write(array(
            'module'    => 'AUTH',
            'item_id'   => $user['id'],
            'item_name' => $user['nama'],
            'action'    => 'LOGIN'
        ));

        return array('status' => TRUE, 'message' => 'Login berhasil!', 'user' => $user);
    }

    /**
     * Auto Login check by cookie
     */
    public function auto_login() {
        $this->load->helper('cookie');
        $token = get_cookie('remember_token');
        if ($token) {
            $user = $this->db->select('u.*, r.role_name, r.is_superadmin, r.can_add_user, r.can_view_all_users')
                         ->from('users u')
                         ->join('roles r', 'u.role_id = r.id', 'left')
                         ->where('u.remember_token', $token)
                         ->where('u.deleted_at IS NULL')
                         ->where('u.is_active', 1)
                         ->where('u.is_blocked', 0)
                         ->get()
                         ->row_array();
            
            if ($user) {
                // Set session
                $this->session->set_userdata(array(
                    'is_logged_in' => TRUE,
                    'user_id'      => $user['id'],
                    'username'     => $user['username'],
                    'nama'         => $user['nama'],
                    'email'        => $user['email'],
                    'avatar'       => $user['avatar'],
                    'role_id'      => $user['role_id'],
                    'role_name'    => $user['role_name'],
                    'is_superadmin'=> $user['is_superadmin'],
                    'can_add_user' => $user['can_add_user'],
                    'can_view_all_users' => $user['can_view_all_users']
                ));
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Proses logout
     */
    public function logout() {
        $this->Log_model->write(array(
            'module'    => 'AUTH',
            'item_id'   => $this->session->userdata('user_id'),
            'item_name' => $this->session->userdata('nama'),
            'action'    => 'LOGOUT'
        ));
        
        $this->load->helper('cookie');
        
        // Remove remember token from DB
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->db->where('id', $user_id)->update('users', array('remember_token' => NULL));
        }

        // Delete cookie
        delete_cookie('remember_token');

        $this->session->sess_destroy();
    }
}
