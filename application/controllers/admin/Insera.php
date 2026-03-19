<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insera extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Insera_model');
    }

    public function index() {
        $this->data['title'] = 'Manajemen Insera';
        $this->data['records'] = $this->Insera_model->get_all();
        $this->template->load('admin/insera/index', $this->data);
    }

    public function get_data() {
        $id = $this->input->post('id', TRUE);
        $data = $this->Insera_model->get_insera($id);
        echo json_encode($data);
    }

    public function save() {
        $id = $this->input->post('id', TRUE);
        $this->form_validation->set_rules('ttr_customer', 'Ttr customer', 'required|trim');
        $this->form_validation->set_rules('summary', 'Summary', 'required|trim');
        $this->form_validation->set_rules('reported_date', 'Reported date', 'required|trim');
        $this->form_validation->set_rules('owner_group', 'Owner group', 'required|trim');
        $this->form_validation->set_rules('owner', 'Owner', 'required|trim');
        $this->form_validation->set_rules('customer_segment', 'Customer segment', 'required|trim');
        $this->form_validation->set_rules('service_type', 'Service type', 'required|trim');
        $this->form_validation->set_rules('witel', 'Witel', 'required|trim');
        $this->form_validation->set_rules('work_zone', 'Work zone', 'required|trim');
        $this->form_validation->set_rules('ticket_status', 'Ticket status', 'required|trim');
        $this->form_validation->set_rules('status_date', 'Status date', 'required|trim');
        $this->form_validation->set_rules('ticket_id_gamas', 'Ticket id gamas', 'required|trim');
        $this->form_validation->set_rules('reported_by', 'Reported by', 'required|trim');
        $this->form_validation->set_rules('contact_phone', 'Contact phone', 'required|trim');
        $this->form_validation->set_rules('contact_name', 'Contact name', 'required|trim');
        $this->form_validation->set_rules('contact_email', 'Contact email', 'required|trim');
        $this->form_validation->set_rules('booking_date', 'Booking date', 'required|trim');
        $this->form_validation->set_rules('description_assignment', 'Description assignment', 'required|trim');
        $this->form_validation->set_rules('reported_priority', 'Reported priority', 'required|trim');
        $this->form_validation->set_rules('source_ticket', 'Source ticket', 'required|trim');
        $this->form_validation->set_rules('subsidiary', 'Subsidiary', 'required|trim');
        $this->form_validation->set_rules('external_ticketid', 'External ticketid', 'required|trim');
        $this->form_validation->set_rules('channel', 'Channel', 'required|trim');
        $this->form_validation->set_rules('customer_type', 'Customer type', 'required|trim');
        $this->form_validation->set_rules('closed_by', 'Closed by', 'required|trim');
        $this->form_validation->set_rules('description_closed_by', 'Description closed by', 'required|trim');
        $this->form_validation->set_rules('customer_id', 'Customer id', 'required|trim');
        $this->form_validation->set_rules('description_customerid', 'Description customerid', 'required|trim');
        $this->form_validation->set_rules('service_id', 'Service id', 'required|trim');
        $this->form_validation->set_rules('service_no', 'Service no', 'required|trim');
        $this->form_validation->set_rules('slg', 'Slg', 'required|trim');
        $this->form_validation->set_rules('technology', 'Technology', 'required|trim');
        $this->form_validation->set_rules('lapul', 'Lapul', 'required|trim');
        $this->form_validation->set_rules('gaul', 'Gaul', 'required|trim');
        $this->form_validation->set_rules('onu_rx', 'Onu rx', 'required|trim');
        $this->form_validation->set_rules('pending_reason', 'Pending reason', 'required|trim');
        $this->form_validation->set_rules('date_modified', 'Date modified', 'required|trim');
        $this->form_validation->set_rules('incident_domain', 'Incident domain', 'required|trim');
        $this->form_validation->set_rules('region', 'Region', 'required|trim');
        $this->form_validation->set_rules('symptom', 'Symptom', 'required|trim');
        $this->form_validation->set_rules('hierarchy_path', 'Hierarchy path', 'required|trim');
        $this->form_validation->set_rules('solution_description', 'Solution description', 'required|trim');
        $this->form_validation->set_rules('description_actualsolution', 'Description actualsolution', 'required|trim');
        $this->form_validation->set_rules('kode_produk', 'Kode produk', 'required|trim');
        $this->form_validation->set_rules('perangkat', 'Perangkat', 'required|trim');
        $this->form_validation->set_rules('technician', 'Technician', 'required|trim');
        $this->form_validation->set_rules('pipe_name', 'Pipe name', 'required|trim');
        $this->form_validation->set_rules('worklog_summary', 'Worklog summary', 'required|trim');
        $this->form_validation->set_rules('last_update_work_log', 'Last update work log', 'required|trim');
        $this->form_validation->set_rules('classification_category', 'Classification category', 'required|trim');
        $this->form_validation->set_rules('realm', 'Realm', 'required|trim');
        $this->form_validation->set_rules('related_to_gamas', 'Related to gamas', 'required|trim');
        $this->form_validation->set_rules('tsc_result', 'Tsc result', 'required|trim');
        $this->form_validation->set_rules('scc_result', 'Scc result', 'required|trim');
        $this->form_validation->set_rules('ttr_agent', 'Ttr agent', 'required|trim');
        $this->form_validation->set_rules('ttr_mitra', 'Ttr mitra', 'required|trim');
        $this->form_validation->set_rules('ttr_nasional', 'Ttr nasional', 'required|trim');
        $this->form_validation->set_rules('ttr_pending', 'Ttr pending', 'required|trim');
        $this->form_validation->set_rules('ttr_region', 'Ttr region', 'required|trim');
        $this->form_validation->set_rules('ttr_witel', 'Ttr witel', 'required|trim');
        $this->form_validation->set_rules('ttr_end_to_end', 'Ttr end to end', 'required|trim');
        $this->form_validation->set_rules('note', 'Note', 'required|trim');
        $this->form_validation->set_rules('guarantee_status', 'Guarantee status', 'required|trim');
        $this->form_validation->set_rules('resolve_date', 'Resolve date', 'required|trim');
        $this->form_validation->set_rules('sn_ont', 'Sn ont', 'required|trim');
        $this->form_validation->set_rules('tipe_ont', 'Tipe ont', 'required|trim');
        $this->form_validation->set_rules('manufacture_ont', 'Manufacture ont', 'required|trim');
        $this->form_validation->set_rules('impacted_site', 'Impacted site', 'required|trim');
        $this->form_validation->set_rules('cts_cause', 'Cts cause', 'required|trim');
        $this->form_validation->set_rules('cts_resolution', 'Cts resolution', 'required|trim');
        $this->form_validation->set_rules('notes_eskalasi', 'Notes eskalasi', 'required|trim');
        $this->form_validation->set_rules('rk_information', 'Rk information', 'required|trim');
        $this->form_validation->set_rules('external_ticket_tier3', 'External ticket tier3', 'required|trim');
        $this->form_validation->set_rules('customer_category', 'Customer category', 'required|trim');
        $this->form_validation->set_rules('classification_path', 'Classification path', 'required|trim');
        $this->form_validation->set_rules('territory_near_end', 'Territory near end', 'required|trim');
        $this->form_validation->set_rules('territory_far_end', 'Territory far end', 'required|trim');
        $this->form_validation->set_rules('urgensi', 'Urgensi', 'required|trim');
        $this->form_validation->set_rules('description_urgensi', 'Description urgensi', 'required|trim');
        $this->form_validation->set_rules('scraped_at', 'Scraped at', 'required|trim');
        $this->form_validation->set_rules('scrape_category', 'Scrape category', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = array(
                'ttr_customer' => strtoupper($this->input->post('ttr_customer', TRUE)),
                'summary' => strtoupper($this->input->post('summary', TRUE)),
                'reported_date' => strtoupper($this->input->post('reported_date', TRUE)),
                'owner_group' => strtoupper($this->input->post('owner_group', TRUE)),
                'owner' => strtoupper($this->input->post('owner', TRUE)),
                'customer_segment' => strtoupper($this->input->post('customer_segment', TRUE)),
                'service_type' => strtoupper($this->input->post('service_type', TRUE)),
                'witel' => strtoupper($this->input->post('witel', TRUE)),
                'work_zone' => strtoupper($this->input->post('work_zone', TRUE)),
                'ticket_status' => strtoupper($this->input->post('ticket_status', TRUE)),
                'status_date' => strtoupper($this->input->post('status_date', TRUE)),
                'ticket_id_gamas' => strtoupper($this->input->post('ticket_id_gamas', TRUE)),
                'reported_by' => strtoupper($this->input->post('reported_by', TRUE)),
                'contact_phone' => preg_replace('/[^0-9\+\-\(\)\s]/', '', $this->input->post('contact_phone', TRUE)),
                'contact_name' => strtoupper($this->input->post('contact_name', TRUE)),
                'contact_email' => strtolower($this->input->post('contact_email', TRUE)),
                'booking_date' => strtoupper($this->input->post('booking_date', TRUE)),
                'description_assignment' => strtoupper($this->input->post('description_assignment', TRUE)),
                'reported_priority' => strtoupper($this->input->post('reported_priority', TRUE)),
                'source_ticket' => strtoupper($this->input->post('source_ticket', TRUE)),
                'subsidiary' => strtoupper($this->input->post('subsidiary', TRUE)),
                'external_ticketid' => strtoupper($this->input->post('external_ticketid', TRUE)),
                'channel' => strtoupper($this->input->post('channel', TRUE)),
                'customer_type' => strtoupper($this->input->post('customer_type', TRUE)),
                'closed_by' => strtoupper($this->input->post('closed_by', TRUE)),
                'description_closed_by' => strtoupper($this->input->post('description_closed_by', TRUE)),
                'customer_id' => strtoupper($this->input->post('customer_id', TRUE)),
                'description_customerid' => strtoupper($this->input->post('description_customerid', TRUE)),
                'service_id' => strtoupper($this->input->post('service_id', TRUE)),
                'service_no' => strtoupper($this->input->post('service_no', TRUE)),
                'slg' => strtoupper($this->input->post('slg', TRUE)),
                'technology' => strtoupper($this->input->post('technology', TRUE)),
                'lapul' => strtoupper($this->input->post('lapul', TRUE)),
                'gaul' => strtoupper($this->input->post('gaul', TRUE)),
                'onu_rx' => strtoupper($this->input->post('onu_rx', TRUE)),
                'pending_reason' => strtoupper($this->input->post('pending_reason', TRUE)),
                'date_modified' => strtoupper($this->input->post('date_modified', TRUE)),
                'incident_domain' => strtoupper($this->input->post('incident_domain', TRUE)),
                'region' => strtoupper($this->input->post('region', TRUE)),
                'symptom' => strtoupper($this->input->post('symptom', TRUE)),
                'hierarchy_path' => strtoupper($this->input->post('hierarchy_path', TRUE)),
                'solution_description' => strtoupper($this->input->post('solution_description', TRUE)),
                'description_actualsolution' => strtoupper($this->input->post('description_actualsolution', TRUE)),
                'kode_produk' => strtoupper($this->input->post('kode_produk', TRUE)),
                'perangkat' => strtoupper($this->input->post('perangkat', TRUE)),
                'technician' => strtoupper($this->input->post('technician', TRUE)),
                'pipe_name' => strtoupper($this->input->post('pipe_name', TRUE)),
                'worklog_summary' => strtoupper($this->input->post('worklog_summary', TRUE)),
                'last_update_work_log' => strtoupper($this->input->post('last_update_work_log', TRUE)),
                'classification_category' => strtoupper($this->input->post('classification_category', TRUE)),
                'realm' => strtoupper($this->input->post('realm', TRUE)),
                'related_to_gamas' => strtoupper($this->input->post('related_to_gamas', TRUE)),
                'tsc_result' => strtoupper($this->input->post('tsc_result', TRUE)),
                'scc_result' => strtoupper($this->input->post('scc_result', TRUE)),
                'ttr_agent' => strtoupper($this->input->post('ttr_agent', TRUE)),
                'ttr_mitra' => strtoupper($this->input->post('ttr_mitra', TRUE)),
                'ttr_nasional' => strtoupper($this->input->post('ttr_nasional', TRUE)),
                'ttr_pending' => strtoupper($this->input->post('ttr_pending', TRUE)),
                'ttr_region' => strtoupper($this->input->post('ttr_region', TRUE)),
                'ttr_witel' => strtoupper($this->input->post('ttr_witel', TRUE)),
                'ttr_end_to_end' => strtoupper($this->input->post('ttr_end_to_end', TRUE)),
                'note' => strtoupper($this->input->post('note', TRUE)),
                'guarantee_status' => strtoupper($this->input->post('guarantee_status', TRUE)),
                'resolve_date' => strtoupper($this->input->post('resolve_date', TRUE)),
                'sn_ont' => strtoupper($this->input->post('sn_ont', TRUE)),
                'tipe_ont' => strtoupper($this->input->post('tipe_ont', TRUE)),
                'manufacture_ont' => strtoupper($this->input->post('manufacture_ont', TRUE)),
                'impacted_site' => strtoupper($this->input->post('impacted_site', TRUE)),
                'cts_cause' => strtoupper($this->input->post('cts_cause', TRUE)),
                'cts_resolution' => strtoupper($this->input->post('cts_resolution', TRUE)),
                'notes_eskalasi' => strtoupper($this->input->post('notes_eskalasi', TRUE)),
                'rk_information' => strtoupper($this->input->post('rk_information', TRUE)),
                'external_ticket_tier3' => strtoupper($this->input->post('external_ticket_tier3', TRUE)),
                'customer_category' => strtoupper($this->input->post('customer_category', TRUE)),
                'classification_path' => strtoupper($this->input->post('classification_path', TRUE)),
                'territory_near_end' => strtoupper($this->input->post('territory_near_end', TRUE)),
                'territory_far_end' => strtoupper($this->input->post('territory_far_end', TRUE)),
                'urgensi' => strtoupper($this->input->post('urgensi', TRUE)),
                'description_urgensi' => strtoupper($this->input->post('description_urgensi', TRUE)),
                'scraped_at' => strtoupper($this->input->post('scraped_at', TRUE)),
                'scrape_category' => strtoupper($this->input->post('scrape_category', TRUE)),
            );

            if ($id) {
                $res = $this->Insera_model->update($id, $data);
                $msg = 'Data berhasil diperbarui.';
            } else {
                $res = $this->Insera_model->insert($data);
                $msg = 'Data berhasil ditambahkan.';
            }

            if ($res) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data.']);
            }
        }
    }

    public function delete() {
        $id = $this->input->post('id', TRUE);
        if ($this->Insera_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }

    public function import_excel() {
        $data_raw = $this->input->post('data', TRUE);
        if (empty($data_raw)) {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data untuk diimport.']);
            return;
        }

        $data = [];
        foreach ($data_raw as $row) {
            $item = [
                'created_at' => date('Y-m-d H:i:s')
            ];
            $item['ttr_customer'] = strtoupper(isset($row['ttr_customer']) ? $row['ttr_customer'] : '');
            $item['summary'] = strtoupper(isset($row['summary']) ? $row['summary'] : '');
            $item['reported_date'] = strtoupper(isset($row['reported_date']) ? $row['reported_date'] : '');
            $item['owner_group'] = strtoupper(isset($row['owner_group']) ? $row['owner_group'] : '');
            $item['owner'] = strtoupper(isset($row['owner']) ? $row['owner'] : '');
            $item['customer_segment'] = strtoupper(isset($row['customer_segment']) ? $row['customer_segment'] : '');
            $item['service_type'] = strtoupper(isset($row['service_type']) ? $row['service_type'] : '');
            $item['witel'] = strtoupper(isset($row['witel']) ? $row['witel'] : '');
            $item['work_zone'] = strtoupper(isset($row['work_zone']) ? $row['work_zone'] : '');
            $item['ticket_status'] = strtoupper(isset($row['ticket_status']) ? $row['ticket_status'] : '');
            $item['status_date'] = strtoupper(isset($row['status_date']) ? $row['status_date'] : '');
            $item['ticket_id_gamas'] = strtoupper(isset($row['ticket_id_gamas']) ? $row['ticket_id_gamas'] : '');
            $item['reported_by'] = strtoupper(isset($row['reported_by']) ? $row['reported_by'] : '');
            $item['contact_phone'] = preg_replace('/[^0-9\+\-\(\)\s]/', '', isset($row['contact_phone']) ? $row['contact_phone'] : '');
            $item['contact_name'] = strtoupper(isset($row['contact_name']) ? $row['contact_name'] : '');
            $item['contact_email'] = strtolower(isset($row['contact_email']) ? $row['contact_email'] : '');
            $item['booking_date'] = strtoupper(isset($row['booking_date']) ? $row['booking_date'] : '');
            $item['description_assignment'] = strtoupper(isset($row['description_assignment']) ? $row['description_assignment'] : '');
            $item['reported_priority'] = strtoupper(isset($row['reported_priority']) ? $row['reported_priority'] : '');
            $item['source_ticket'] = strtoupper(isset($row['source_ticket']) ? $row['source_ticket'] : '');
            $item['subsidiary'] = strtoupper(isset($row['subsidiary']) ? $row['subsidiary'] : '');
            $item['external_ticketid'] = strtoupper(isset($row['external_ticketid']) ? $row['external_ticketid'] : '');
            $item['channel'] = strtoupper(isset($row['channel']) ? $row['channel'] : '');
            $item['customer_type'] = strtoupper(isset($row['customer_type']) ? $row['customer_type'] : '');
            $item['closed_by'] = strtoupper(isset($row['closed_by']) ? $row['closed_by'] : '');
            $item['description_closed_by'] = strtoupper(isset($row['description_closed_by']) ? $row['description_closed_by'] : '');
            $item['customer_id'] = strtoupper(isset($row['customer_id']) ? $row['customer_id'] : '');
            $item['description_customerid'] = strtoupper(isset($row['description_customerid']) ? $row['description_customerid'] : '');
            $item['service_id'] = strtoupper(isset($row['service_id']) ? $row['service_id'] : '');
            $item['service_no'] = strtoupper(isset($row['service_no']) ? $row['service_no'] : '');
            $item['slg'] = strtoupper(isset($row['slg']) ? $row['slg'] : '');
            $item['technology'] = strtoupper(isset($row['technology']) ? $row['technology'] : '');
            $item['lapul'] = strtoupper(isset($row['lapul']) ? $row['lapul'] : '');
            $item['gaul'] = strtoupper(isset($row['gaul']) ? $row['gaul'] : '');
            $item['onu_rx'] = strtoupper(isset($row['onu_rx']) ? $row['onu_rx'] : '');
            $item['pending_reason'] = strtoupper(isset($row['pending_reason']) ? $row['pending_reason'] : '');
            $item['date_modified'] = strtoupper(isset($row['date_modified']) ? $row['date_modified'] : '');
            $item['incident_domain'] = strtoupper(isset($row['incident_domain']) ? $row['incident_domain'] : '');
            $item['region'] = strtoupper(isset($row['region']) ? $row['region'] : '');
            $item['symptom'] = strtoupper(isset($row['symptom']) ? $row['symptom'] : '');
            $item['hierarchy_path'] = strtoupper(isset($row['hierarchy_path']) ? $row['hierarchy_path'] : '');
            $item['solution_description'] = strtoupper(isset($row['solution_description']) ? $row['solution_description'] : '');
            $item['description_actualsolution'] = strtoupper(isset($row['description_actualsolution']) ? $row['description_actualsolution'] : '');
            $item['kode_produk'] = strtoupper(isset($row['kode_produk']) ? $row['kode_produk'] : '');
            $item['perangkat'] = strtoupper(isset($row['perangkat']) ? $row['perangkat'] : '');
            $item['technician'] = strtoupper(isset($row['technician']) ? $row['technician'] : '');
            $item['pipe_name'] = strtoupper(isset($row['pipe_name']) ? $row['pipe_name'] : '');
            $item['worklog_summary'] = strtoupper(isset($row['worklog_summary']) ? $row['worklog_summary'] : '');
            $item['last_update_work_log'] = strtoupper(isset($row['last_update_work_log']) ? $row['last_update_work_log'] : '');
            $item['classification_category'] = strtoupper(isset($row['classification_category']) ? $row['classification_category'] : '');
            $item['realm'] = strtoupper(isset($row['realm']) ? $row['realm'] : '');
            $item['related_to_gamas'] = strtoupper(isset($row['related_to_gamas']) ? $row['related_to_gamas'] : '');
            $item['tsc_result'] = strtoupper(isset($row['tsc_result']) ? $row['tsc_result'] : '');
            $item['scc_result'] = strtoupper(isset($row['scc_result']) ? $row['scc_result'] : '');
            $item['ttr_agent'] = strtoupper(isset($row['ttr_agent']) ? $row['ttr_agent'] : '');
            $item['ttr_mitra'] = strtoupper(isset($row['ttr_mitra']) ? $row['ttr_mitra'] : '');
            $item['ttr_nasional'] = strtoupper(isset($row['ttr_nasional']) ? $row['ttr_nasional'] : '');
            $item['ttr_pending'] = strtoupper(isset($row['ttr_pending']) ? $row['ttr_pending'] : '');
            $item['ttr_region'] = strtoupper(isset($row['ttr_region']) ? $row['ttr_region'] : '');
            $item['ttr_witel'] = strtoupper(isset($row['ttr_witel']) ? $row['ttr_witel'] : '');
            $item['ttr_end_to_end'] = strtoupper(isset($row['ttr_end_to_end']) ? $row['ttr_end_to_end'] : '');
            $item['note'] = strtoupper(isset($row['note']) ? $row['note'] : '');
            $item['guarantee_status'] = strtoupper(isset($row['guarantee_status']) ? $row['guarantee_status'] : '');
            $item['resolve_date'] = strtoupper(isset($row['resolve_date']) ? $row['resolve_date'] : '');
            $item['sn_ont'] = strtoupper(isset($row['sn_ont']) ? $row['sn_ont'] : '');
            $item['tipe_ont'] = strtoupper(isset($row['tipe_ont']) ? $row['tipe_ont'] : '');
            $item['manufacture_ont'] = strtoupper(isset($row['manufacture_ont']) ? $row['manufacture_ont'] : '');
            $item['impacted_site'] = strtoupper(isset($row['impacted_site']) ? $row['impacted_site'] : '');
            $item['cts_cause'] = strtoupper(isset($row['cts_cause']) ? $row['cts_cause'] : '');
            $item['cts_resolution'] = strtoupper(isset($row['cts_resolution']) ? $row['cts_resolution'] : '');
            $item['notes_eskalasi'] = strtoupper(isset($row['notes_eskalasi']) ? $row['notes_eskalasi'] : '');
            $item['rk_information'] = strtoupper(isset($row['rk_information']) ? $row['rk_information'] : '');
            $item['external_ticket_tier3'] = strtoupper(isset($row['external_ticket_tier3']) ? $row['external_ticket_tier3'] : '');
            $item['customer_category'] = strtoupper(isset($row['customer_category']) ? $row['customer_category'] : '');
            $item['classification_path'] = strtoupper(isset($row['classification_path']) ? $row['classification_path'] : '');
            $item['territory_near_end'] = strtoupper(isset($row['territory_near_end']) ? $row['territory_near_end'] : '');
            $item['territory_far_end'] = strtoupper(isset($row['territory_far_end']) ? $row['territory_far_end'] : '');
            $item['urgensi'] = strtoupper(isset($row['urgensi']) ? $row['urgensi'] : '');
            $item['description_urgensi'] = strtoupper(isset($row['description_urgensi']) ? $row['description_urgensi'] : '');
            $item['scraped_at'] = strtoupper(isset($row['scraped_at']) ? $row['scraped_at'] : '');
            $item['scrape_category'] = strtoupper(isset($row['scrape_category']) ? $row['scrape_category'] : '');
            $data[] = $item;
        }

        if ($this->Insera_model->insert_batch($data)) {
            echo json_encode(['status' => 'success', 'message' => count($data) . ' Data berhasil diimport.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengimport data balance.']);
        }
    }
}
