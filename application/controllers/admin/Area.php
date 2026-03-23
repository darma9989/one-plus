<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Area_model');
    }

    public function index() {
        $this->data['title'] = 'Master Hierarki Area';
        // Get all parents for dropdowns
        $this->data['witel']        = $this->Area_model->get_witel();
        $this->data['service_area'] = $this->Area_model->get_service_area();
        $this->data['sektor']       = $this->Area_model->get_sektor();
        $this->data['sto']          = $this->Area_model->get_sto();
        $this->data['hierarchy']    = $this->Area_model->get_hierarchy();
        
        $this->template->load('admin/area/index', $this->data);
    }

    // --- AJAX GET ---
    public function get_witel()        { echo json_encode(['data' => $this->Area_model->get_witel()]); }
    public function get_service_area() { echo json_encode(['data' => $this->Area_model->get_service_area()]); }
    public function get_sektor()       { echo json_encode(['data' => $this->Area_model->get_sektor()]); }
    public function get_sto()          { echo json_encode(['data' => $this->Area_model->get_sto()]); }
    public function get_wilsus()       { echo json_encode(['data' => $this->Area_model->get_wilsus()]); }

    public function get_detail_witel() { echo json_encode($this->Area_model->get_witel_by_id($this->input->post('id'))); }
    public function get_detail_sa()    { echo json_encode($this->Area_model->get_service_area_by_id($this->input->post('id'))); }
    public function get_detail_sk()    { echo json_encode($this->Area_model->get_sektor_by_id($this->input->post('id'))); }
    public function get_detail_sto()   { echo json_encode($this->Area_model->get_sto_by_id($this->input->post('id'))); }
    public function get_detail_ws()    { echo json_encode($this->Area_model->get_wilsus_by_id($this->input->post('id'))); }

    // --- SAVE ---
    public function save_witel() {
        $id = $this->input->post('id', TRUE);
        $data = ['nama_witel' => strtoupper($this->input->post('nama_witel', TRUE))];
        $res = $this->Area_model->save_witel($id, $data);
        echo json_encode($res ? ['status'=>'success', 'message'=>'Data disimpan'] : ['status'=>'error']);
    }

    public function save_service_area() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'witel_id' => $this->input->post('witel_id', TRUE),
            'nama_service_area' => strtoupper($this->input->post('nama_service_area', TRUE))
        ];
        $res = $this->Area_model->save_service_area($id, $data);
        echo json_encode($res ? ['status'=>'success', 'message'=>'Data disimpan'] : ['status'=>'error']);
    }

    public function save_sektor() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'service_area_id' => $this->input->post('service_area_id', TRUE),
            'nama_sektor' => strtoupper($this->input->post('nama_sektor', TRUE))
        ];
        $res = $this->Area_model->save_sektor($id, $data);
        echo json_encode($res ? ['status'=>'success', 'message'=>'Data disimpan'] : ['status'=>'error']);
    }

    public function save_sto() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'sektor_id' => $this->input->post('sektor_id', TRUE),
            'nama_sto' => strtoupper($this->input->post('nama_sto', TRUE)),
            'kode_sto' => strtoupper($this->input->post('kode_sto', TRUE))
        ];
        $res = $this->Area_model->save_sto($id, $data);
        echo json_encode($res ? ['status'=>'success', 'message'=>'Data disimpan'] : ['status'=>'error']);
    }

    public function save_wilsus() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'sto_id' => $this->input->post('sto_id', TRUE),
            'nama_wilsus' => strtoupper($this->input->post('nama_wilsus', TRUE))
        ];
        $res = $this->Area_model->save_wilsus($id, $data);
        echo json_encode($res ? ['status'=>'success', 'message'=>'Data disimpan'] : ['status'=>'error']);
    }

    // --- DELETE ---
    public function delete_any() {
        $type = $this->input->post('type', TRUE);
        $id   = $this->input->post('id', TRUE);
        $res = false;
        if ($type == 'witel') $res = $this->Area_model->delete_witel($id);
        if ($type == 'sa')    $res = $this->Area_model->delete_service_area($id);
        if ($type == 'sk')    $res = $this->Area_model->delete_sektor($id);
        if ($type == 'sto')   $res = $this->Area_model->delete_sto($id);
        if ($type == 'ws')    $res = $this->Area_model->delete_wilsus($id);
        echo json_encode($res ? ['status'=>'success', 'message'=>'Data dihapus'] : ['status'=>'error', 'message'=>'Gagal hapus data (Mungkin sedang digunakan sebagai induk).']);
    }
}
