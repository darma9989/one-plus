<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['title'] = 'System Settings';
        $this->data['all_settings'] = $this->Setting_model->get_all();
        $this->template->load('admin/settings/index', $this->data);
    }

    public function save() {
        $settings = $this->input->post();
        unset($settings['csrf_token']); // Remove CSRF if present

        // Handle File Upload for Logo
        if (isset($_FILES['app_logo']) && !empty($_FILES['app_logo']['name'])) {
            $uploadPath = FCPATH . 'uploads/settings/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, TRUE);
            }

            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico|webp|svg';
            $config['max_size']      = 5120; // 5MB
            $config['file_name']     = 'logo_' . time();
            
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('app_logo')) {
                $upload_data = $this->upload->data();
                $settings['app_logo'] = $upload_data['file_name'];
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Upload failed: ' . strip_tags($this->upload->display_errors())));
                return;
            }
        }

        $old_settings = $this->Setting_model->get_all();

        if ($this->Setting_model->save_batch($settings)) {
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'SETTINGS',
                'action'    => 'UPDATE',
                'before'    => $old_settings,
                'after'     => $settings
            ));
            echo json_encode(array('status' => 'success', 'message' => 'Settings berhasil disimpan.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan settings.'));
        }
    }
}
