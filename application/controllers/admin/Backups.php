<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backups extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Backup_model');
    }

    public function index() {
        $this->data['title'] = 'Database Backup & Restore';
        $this->data['backups'] = $this->Backup_model->get_history();
        $this->template->load('admin/backups/index', $this->data);
    }

    public function backup() {
        $result = $this->Backup_model->create_backup();
        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Snapshot database berhasil dibuat.', 'filename' => $result['filename']));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal membuat snapshot database.'));
        }
    }

    public function download($id) {
        $backup = $this->Backup_model->get_backup($id);
        if (!$backup) {
            $this->session->set_flashdata('error', 'File tidak ditemukan.');
            redirect('admin/backups');
        }

        $backup_path = $this->Setting_model->get('backup_path') ?: './uploads/backups/';
        $file = $backup_path . $backup['filename'];

        if (file_exists($file)) {
            $this->load->helper('download');
            force_download($file, NULL);
        } else {
            $this->session->set_flashdata('error', 'File fisik tidak ditemukan di server.');
            redirect('admin/backups');
        }
    }

    public function delete($id) {
        $backup = $this->Backup_model->get_backup($id);
        if ($backup) {
            $backup_path = $this->Setting_model->get('backup_path') ?: './uploads/backups/';
            @unlink($backup_path . $backup['filename']);
            $this->Backup_model->delete_backup($id);
            
            $this->Log_model->write(array(
                'module'    => 'SYSTEM',
                'sub_module'=> 'BACKUP',
                'item_name' => $backup['filename'],
                'action'    => 'BACKUP_DELETE'
            ));
            
            echo json_encode(array('status' => 'success', 'message' => 'Snapshot berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'ID snapshot tidak valid.'));
        }
    }

    public function restore() {
        if (empty($_FILES['backup_file']['name'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Pilih file SQL terlebih dahulu.'));
            return;
        }

        $path = './uploads/backups/';
        if (!is_dir($path)) mkdir($path, 0777, TRUE);

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'sql';
        $config['max_size'] = 50000;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('backup_file')) {
            echo json_encode(array('status' => 'error', 'message' => $this->upload->display_errors('', '')));
        } else {
            $upload_data = $this->upload->data();
            if ($this->Backup_model->restore_backup($upload_data['full_path'])) {
                echo json_encode(array('status' => 'success', 'message' => 'Database berhasil di-restore.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal restore database.'));
            }
            @unlink($upload_data['full_path']);
        }
    }
}
