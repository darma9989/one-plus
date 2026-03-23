<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model {

    // --- WITEL ---
    public function get_hierarchy() {
        $witel = $this->get_witel();
        foreach ($witel as &$w) {
            $w['service_areas'] = $this->db->get_where('mst_service_area', ['witel_id' => $w['id']])->result_array();
            foreach ($w['service_areas'] as &$sa) {
                $sa['sektors'] = $this->db->get_where('mst_sektor', ['service_area_id' => $sa['id']])->result_array();
                foreach ($sa['sektors'] as &$sk) {
                    $sk['stos'] = $this->db->get_where('mst_sto', ['sektor_id' => $sk['id']])->result_array();
                    foreach ($sk['stos'] as &$sto) {
                        $sto['wilsus'] = $this->db->get_where('mst_wilsus', ['sto_id' => $sto['id']])->result_array();
                    }
                }
            }
        }
        return $witel;
    }

    public function get_witel() {
        return $this->db->get('mst_witel')->result_array();
    }
    public function get_witel_by_id($id) {
        return $this->db->get_where('mst_witel', ['id' => $id])->row_array();
    }
    public function save_witel($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('mst_witel', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('mst_witel', $data);
    }
    public function delete_witel($id) {
        $this->db->where('id', $id);
        return $this->db->delete('mst_witel');
    }

    // --- SERVICE AREA ---
    public function get_service_area() {
        $this->db->select('sa.*, w.nama_witel');
        $this->db->from('mst_service_area sa');
        $this->db->join('mst_witel w', 'w.id = sa.witel_id');
        return $this->db->get()->result_array();
    }
    public function get_service_area_by_id($id) {
        return $this->db->get_where('mst_service_area', ['id' => $id])->row_array();
    }
    public function save_service_area($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('mst_service_area', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('mst_service_area', $data);
    }
    public function delete_service_area($id) {
        $this->db->where('id', $id);
        return $this->db->delete('mst_service_area');
    }

    // --- SEKTOR ---
    public function get_sektor() {
        $this->db->select('sk.*, sa.nama_service_area');
        $this->db->from('mst_sektor sk');
        $this->db->join('mst_service_area sa', 'sa.id = sk.service_area_id');
        return $this->db->get()->result_array();
    }
    public function get_sektor_by_id($id) {
        return $this->db->get_where('mst_sektor', ['id' => $id])->row_array();
    }
    public function save_sektor($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('mst_sektor', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('mst_sektor', $data);
    }
    public function delete_sektor($id) {
        $this->db->where('id', $id);
        return $this->db->delete('mst_sektor');
    }

    // --- STO ---
    public function get_sto() {
        $this->db->select('sto.*, sk.nama_sektor');
        $this->db->from('mst_sto sto');
        $this->db->join('mst_sektor sk', 'sk.id = sto.sektor_id');
        return $this->db->get()->result_array();
    }
    public function get_sto_by_id($id) {
        return $this->db->get_where('mst_sto', ['id' => $id])->row_array();
    }
    public function save_sto($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('mst_sto', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('mst_sto', $data);
    }
    public function delete_sto($id) {
        $this->db->where('id', $id);
        return $this->db->delete('mst_sto');
    }

    // --- WILSUS ---
    public function get_wilsus() {
        $this->db->select('ws.*, sto.nama_sto, sto.kode_sto');
        $this->db->from('mst_wilsus ws');
        $this->db->join('mst_sto sto', 'sto.id = ws.sto_id');
        return $this->db->get()->result_array();
    }
    public function get_wilsus_by_id($id) {
        return $this->db->get_where('mst_wilsus', ['id' => $id])->row_array();
    }
    public function save_wilsus($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('mst_wilsus', $data);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('mst_wilsus', $data);
    }
    public function delete_wilsus($id) {
        $this->db->where('id', $id);
        return $this->db->delete('mst_wilsus');
    }
}
