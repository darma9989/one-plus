<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller — Login/Logout
 */
class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function index() {
        // Jika sudah login atau auto_login berhasil, redirect ke dashboard
        if ($this->session->userdata('is_logged_in') || $this->Auth_model->auto_login()) {
            redirect('dashboard');
        }
        $data = array();
        $data['settings'] = $this->Setting_model->get_all();
        $data['app_name'] = $this->Setting_model->get('app_name');
        $data['app_logo'] = $this->Setting_model->get('app_logo');
        $data['active_theme'] = $this->Setting_model->get('active_theme');
        $this->load->view('auth/login', $data);
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $remember_me = $this->input->post('remember_me') ? TRUE : FALSE;

        $result = $this->Auth_model->login($username, $password, $remember_me);

        if ($result['status']) {
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('auth');
        }
    }

    public function logout() {
        $this->Auth_model->logout();
        redirect('auth');
    }
}
