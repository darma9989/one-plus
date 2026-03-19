<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Backup_model — Database Backup & Restore
 */
class Backup_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('file');
    }

    /**
     * Buat backup database
     */
    public function create_backup() {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        $prefs = array(
            'format' => 'sql',
            'filename' => $filename
        );

        $backup = $this->dbutil->backup($prefs);
        $backup_path = $this->Setting_model->get('backup_path');
        if (!$backup_path) $backup_path = './uploads/backups/';

        if (!is_dir($backup_path)) {
            mkdir($backup_path, 0777, TRUE);
        }

        $filepath = $backup_path . $filename;
        if (!write_file($filepath, $backup)) return FALSE;

        // Simpan ke history
        $this->db->insert('backup_history', array(
            'filename'    => $filename,
            'filesize'    => $this->format_size(strlen($backup)),
            'backup_type' => 'manual',
            'created_by'  => $this->session->userdata('user_id'),
            'created_at'  => date('Y-m-d H:i:s')
        ));

        $this->Log_model->write(array(
            'module'    => 'SYSTEM',
            'sub_module'=> 'BACKUP',
            'item_name' => $filename,
            'action'    => 'BACKUP_CREATE'
        ));

        return array('filename' => $filename, 'backup' => $backup);
    }

    /**
     * Ambil backup by ID
     */
    public function get_backup($id) {
        return $this->db->get_where('backup_history', array('id' => $id))->row_array();
    }

    /**
     * Hapus record backup
     */
    public function delete_backup($id) {
        return $this->db->delete('backup_history', array('id' => $id));
    }

    /**
     * Restore dari file SQL
     */
    public function restore_backup($file_path) {
        if (!file_exists($file_path)) return FALSE;

        $lines = file($file_path);
        
        $this->db->trans_start();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        $templine = '';
        foreach ($lines as $line) {
            // Skip comments
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $templine .= $line;
            // Evaluasi saat ketemu penutup statement
            if (substr(trim($line), -1, 1) == ';') {
                $this->db->query($templine);
                $templine = '';
            }
        }
        
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }

        $this->Log_model->write(array(
            'module'    => 'SYSTEM',
            'sub_module'=> 'BACKUP',
            'item_name' => basename($file_path),
            'action'    => 'BACKUP_RESTORE'
        ));

        return TRUE;
    }

    /**
     * Ambil history backup
     */
    public function get_history() {
        $this->db->select('bh.*, u.nama as created_by_name');
        $this->db->from('backup_history bh');
        $this->db->join('users u', 'bh.created_by = u.id', 'left');
        $this->db->order_by('bh.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Format ukuran file
     */
    private function format_size($bytes) {
        $units = array('B', 'KB', 'MB', 'GB');
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
