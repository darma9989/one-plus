<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model {

    protected $db_db_lama;

    public function __construct() {
        parent::__construct();
        $this->db_db_lama = $this->load->database('db_lama', TRUE);
    }


    // --- WITEL ---
    public function get_hierarchy() {
        $witel = $this->db_db_lama->get('mst_witel')->result_array();
        foreach ($witel as &$w) {
            $w['service_areas'] = $this->db_db_lama->get_where('mst_service_area', ['witel_id' => $w['id']])->result_array();
            foreach ($w['service_areas'] as &$sa) {
                $sa['sektors'] = $this->db_db_lama->get_where('mst_sektor', ['service_area_id' => $sa['id']])->result_array();
                foreach ($sa['sektors'] as &$sk) {
                    $sk['stos'] = $this->db_db_lama->get_where('mst_sto', ['sektor_id' => $sk['id']])->result_array();
                    foreach ($sk['stos'] as &$sto) {
                        $sto['wilsus'] = $this->db_db_lama->get_where('mst_wilsus', ['sto_id' => $sto['id']])->result_array();
                    }
                }
            }
        }
        return $witel;
    }

    public function get_witel() {
        return $this->db_db_lama->get('mst_witel')->result_array();
    }
    
    public function get_witel_by_id($id) {
        return $this->db_db_lama->get_where('mst_witel', ['id' => $id])->row_array();
    }
    
    public function save_witel($id, $data) {
        if ($id) {
            $this->db_db_lama->where('id', $id);
            return $this->db_db_lama->update('mst_witel', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db_db_lama->insert('mst_witel', $data);
    }
    
    public function delete_witel($id) {
        $this->db_db_lama->where('id', $id);
        return $this->db_db_lama->delete('mst_witel');
    }

    // --- SERVICE AREA ---
    public function get_service_area() {
        $this->db_db_lama->select('sa.*, w.nama_witel');
        $this->db_db_lama->from('mst_service_area sa');
        $this->db_db_lama->join('mst_witel w', 'w.id = sa.witel_id');
        return $this->db_db_lama->get()->result_array();
    }
    
    public function get_service_area_by_id($id) {
        return $this->db_db_lama->get_where('mst_service_area', ['id' => $id])->row_array();
    }
    
    public function save_service_area($id, $data) {
        if ($id) {
            $this->db_db_lama->where('id', $id);
            return $this->db_db_lama->update('mst_service_area', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db_db_lama->insert('mst_service_area', $data);
    }
    
    public function delete_service_area($id) {
        $this->db_db_lama->where('id', $id);
        return $this->db_db_lama->delete('mst_service_area');
    }

    // --- SEKTOR ---
    public function get_sektor() {
        $this->db_db_lama->select('sk.*, sa.nama_service_area');
        $this->db_db_lama->from('mst_sektor sk');
        $this->db_db_lama->join('mst_service_area sa', 'sa.id = sk.service_area_id');
        return $this->db_db_lama->get()->result_array();
    }
    
    public function get_sektor_by_id($id) {
        return $this->db_db_lama->get_where('mst_sektor', ['id' => $id])->row_array();
    }
    
    public function save_sektor($id, $data) {
        if ($id) {
            $this->db_db_lama->where('id', $id);
            return $this->db_db_lama->update('mst_sektor', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db_db_lama->insert('mst_sektor', $data);
    }
    
    public function delete_sektor($id) {
        $this->db_db_lama->where('id', $id);
        return $this->db_db_lama->delete('mst_sektor');
    }

    // --- STO ---
    public function get_sto() {
        $this->db_db_lama->select('sto.*, sk.nama_sektor');
        $this->db_db_lama->from('mst_sto sto');
        $this->db_db_lama->join('mst_sektor sk', 'sk.id = sto.sektor_id');
        return $this->db_db_lama->get()->result_array();
    }
    
    public function get_sto_by_id($id) {
        return $this->db_db_lama->get_where('mst_sto', ['id' => $id])->row_array();
    }
    
    public function save_sto($id, $data) {
        if ($id) {
            $this->db_db_lama->where('id', $id);
            return $this->db_db_lama->update('mst_sto', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db_db_lama->insert('mst_sto', $data);
    }
    
    public function delete_sto($id) {
        $this->db_db_lama->where('id', $id);
        return $this->db_db_lama->delete('mst_sto');
    }

    // --- WILSUS ---
    public function get_wilsus() {
        $this->db_db_lama->select('ws.*, sto.nama_sto, sto.kode_sto');
        $this->db_db_lama->from('mst_wilsus ws');
        $this->db_db_lama->join('mst_sto sto', 'sto.id = ws.sto_id');
        return $this->db_db_lama->get()->result_array();
    }
    
    public function get_wilsus_by_id($id) {
        return $this->db_db_lama->get_where('mst_wilsus', ['id' => $id])->row_array();
    }
    
    public function save_wilsus($id, $data) {
        if ($id) {
            $this->db_db_lama->where('id', $id);
            return $this->db_db_lama->update('mst_wilsus', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db_db_lama->insert('mst_wilsus', $data);
    }
    
    public function delete_wilsus($id) {
        $this->db_db_lama->where('id', $id);
        return $this->db_db_lama->delete('mst_wilsus');
    }
}