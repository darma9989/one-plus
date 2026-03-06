<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller — Base Controller
 */
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
}

/**
 * Auth_Controller — Controller untuk area yang butuh login
 * Semua controller backend harus extends class ini
 */
class Auth_Controller extends MY_Controller {

    protected $data = array();

    public function __construct() {
        parent::__construct();

        // 1. Cek Authentication
        if (!$this->session->userdata('is_logged_in')) {
            $this->load->model('Auth_model');
            if (!$this->Auth_model->auto_login()) {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(array('status' => 'error', 'message' => 'Sesi habis, silakan login kembali.'));
                    exit;
                }
                $this->session->set_flashdata('error', 'Sesi habis, silakan login kembali.');
                redirect('auth');
            }
        }

        // 2. Cek Permission (proteksi akses URL langsung)
        $this->load->model('Permission_model');
        $role_id = $this->session->userdata('role_id');
        $current_uri = $this->uri->uri_string();
        $this->data['current_uri'] = $current_uri;

        if (!$this->Permission_model->has_access($role_id, $current_uri)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => 'Anda tidak memiliki hak akses.'));
                exit;
            }
            set_status_header(403);
            echo $this->load->view('errors/html/error_403', array(
                'message' => 'Sistem mendeteksi bahwa peran Anda saat ini tidak memiliki izin untuk membuka halaman tersebut.<br><br><b>Silakan hubungi Administrator sistem</b> apabila Anda membutuhkan akses atau pembukaan blokir ke modul ini.'
            ), TRUE);
            exit;
        }

        // 3. Cek module aktif
        $this->config->load('modules', TRUE);
        $modules = $this->config->item('modules', 'modules');
        $controller = $this->router->fetch_class();
        if (isset($modules[$controller]) && $modules[$controller] === FALSE) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => 'Module ini sedang dinonaktifkan.'));
                exit;
            }
            $this->session->set_flashdata('error', 'Module ini sedang dinonaktifkan oleh administrator.');
            redirect('dashboard');
        }

        // 4. Load global data untuk views
        $this->data['menu'] = $this->Permission_model->get_menu_for_role($role_id);
        $this->data['current_user'] = array(
            'id'       => $this->session->userdata('user_id'),
            'username' => $this->session->userdata('username'),
            'nama'     => $this->session->userdata('nama'),
            'email'    => $this->session->userdata('email'),
            'avatar'   => $this->session->userdata('avatar'),
            'role'     => $this->session->userdata('role_name'),
            'role_id'  => $role_id
        );

        // 5. Load breadcrumb info
        $this->load->model('Menu_model');
        $this->data['breadcrumbs'] = $this->Menu_model->get_breadcrumb($current_uri);

        // 6. Load system settings
        $this->data['settings'] = $this->Setting_model->get_all();
        $this->data['app_name'] = $this->Setting_model->get('app_name');
        $this->data['sys_app_name'] = $this->Setting_model->get('app_name');
        $this->data['sys_app_logo'] = $this->Setting_model->get('app_logo');
        $this->data['active_theme'] = $this->Setting_model->get('active_theme');
        $this->data['sidebar_layout'] = $this->Setting_model->get('sidebar_layout');
        $this->data['skin_color'] = $this->Setting_model->get('skin_color');

        // 7. Check Maintenance Mode
        $maintenance_mode = $this->Setting_model->get('maintenance_mode');
        if ($maintenance_mode == '1' && !$this->session->userdata('is_superadmin')) {
            $data = array(
                'message'      => $this->Setting_model->get('maintenance_message'),
                'sys_app_name' => $this->Setting_model->get('app_name')
            );
            $this->load->view('maintenance', $data);
            $this->output->_display();
            exit;
        }
    }
}

/**
 * Admin_Controller — Extends Auth_Controller untuk admin area
 */
class Admin_Controller extends Auth_Controller {
    public function __construct() {
        parent::__construct();
    }
}
