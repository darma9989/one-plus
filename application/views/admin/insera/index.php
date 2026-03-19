<style>
    :root {
        --mac-bg: #1c1c1e;
        --mac-card: #2c2c2e;
        --mac-card-header: rgba(44, 44, 46, 0.8);
        --mac-text: #ffffff;
        --mac-text-dim: #a1a1a6;
        --mac-border: #38383a;
        --mac-blue: #0A84FF;
        --mac-green: #30D158;
        --mac-red: #FF453A;
        --mac-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    <?php 
    if (!function_exists('formatTTR')) {
        function formatTTR($seconds) {
            if (!$seconds || !is_numeric($seconds)) return '00:00';
            $hrs = floor($seconds / 3600);
            $mins = floor(($seconds % 3600) / 60);
            return sprintf('%02d:%02d', $hrs, $mins);
        }
    }
    ?>

    body {
        background-color: var(--mac-bg) !important;
        color: var(--mac-text) !important;
    }

    .content-wrapper {
        background-color: var(--mac-bg) !important;
    }

    /* Modern Card Layout */
    .box {
        background: var(--mac-card) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        box-shadow: var(--mac-shadow) !important;
        overflow: hidden;
        color: var(--mac-text) !important;
    }

    .box-header {
        background: var(--mac-card-header) !important;
        border-bottom: 1px solid var(--mac-border) !important;
        backdrop-filter: blur(10px);
        padding: 15px 20px !important;
    }

    .box-title {
        color: var(--mac-text) !important;
        font-weight: 700 !important;
    }

    /* Table Styling */
    .table {
        color: var(--mac-text) !important;
        border-color: var(--mac-border) !important;
    }

    .table-bordered, .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid var(--mac-border) !important;
    }

    /* Hitam Menyala Header */
    #tblData thead tr, #tblData thead th {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: var(--mac-border) !important;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    .table-hover > tbody > tr:hover {
        background-color: rgba(255, 255, 255, 0.07) !important;
    }

    /* DataTable Controls - Dark Mode */
    .dataTables_wrapper .dataTables_filter input {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
        padding: 5px 10px !important;
    }

    .dataTables_wrapper .dataTables_length select {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--mac-text-dim) !important;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li > a {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li.active > a {
        background: #444446 !important;
        border-color: #444446 !important;
    }

    /* Style for Export Buttons (Excel, PDF, Print) */
    .dt-buttons .btn {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
        padding: 5px 12px !important;
        margin-right: 5px !important;
        font-size: 12px !important;
        transition: all 0.2s ease !important;
    }

    /* Modal Styling - Dark Mode */
    .modal-content {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        color: #fff !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.8) !important;
    }

    .modal-header {
        background: #000000 !important;
        border-bottom: 1px solid var(--mac-border) !important;
        padding: 20px 25px !important;
    }

    .modal-body {
        background: #000000 !important;
        padding: 25px !important;
    }

    .modal-footer {
        background: #000000 !important;
        border-top: 1px solid var(--mac-border) !important;
    }

    .form-control {
        background: #1c1c1e !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 8px !important;
        padding: 10px 12px !important;
        height: auto !important;
    }

    .form-control:focus {
        border-color: var(--mac-blue) !important;
        box-shadow: 0 0 0 3px rgba(10, 132, 255, 0.2) !important;
    }

    label {
        color: var(--mac-text-dim) !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        margin-bottom: 8px !important;
    }

    hr {
        border-top: 1px solid var(--mac-border) !important;
    }

    .text-muted {
        color: var(--mac-text-dim) !important;
    }

    /* Modal Styling - Black Theme */
    .modal-content {
        background: #0000   00 !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        color: #fff !important;
    }

    .modal-header {
        background: #000000 !important;
        border-bottom: 1px solid var(--mac-border) !important;
    }

    .modal-body {
        background: #000000 !important;
    }

    .modal-footer {
        background: #000000 !important;
        border-top: 1px solid var(--mac-border) !important;
    }

    .form-control {
        background: #1c1c1e !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
    }

    .form-control:focus {
        border-color: var(--mac-blue) !important;
        box-shadow: 0 0 0 2px rgba(10, 132, 255, 0.3) !important;
    }

    label {
        color: var(--mac-text-dim) !important;
        font-weight: 600 !important;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: var(--mac-bg);
    }
    ::-webkit-scrollbar-thumb {
        background: #3a3a3c;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #48484a;
    }
</style>

<!-- Data Table Box -->
<div class="box border-0 shadow-sm">
    <div class="box-header with-border" style="padding: 15px 20px;">
        <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-list" style="color: var(--mac-blue);"></i> Data Insera</h3>
        <div class="pull-right">
            <div class="btn-group" style="margin-right: 5px;">
                <button type="button" class="btn btn-sm btn-flat dropdown-toggle" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid var(--mac-border);" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i> Tools <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="javascript:void(0)" onclick="showImportModal()"><i class="fa fa-upload"></i> Import Excel</a></li>
                    <li><a href="javascript:void(0)" onclick="exportExcel()"><i class="fa fa-download"></i> Export Excel</a></li>
                </ul>
            </div>
            <button class="btn btn-sm btn-flat" style="background: var(--mac-blue); color: #fff;" onclick="showAddModal()"><i class="fa fa-plus"></i> Tambah Data Baru</button>
        </div>
    </div>
    <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="tblData" style="width: 100%;">
                <thead>
                    <tr>
                        <th width="30" class="text-center">No</th>
                        <th>Ticket id</th>
                        <th>Ttr customer</th>
                        <th>Summary</th>
                        <th>Reported date</th>
                        <th>Owner group</th>
                        <th>Owner</th>
                        <th>Customer segment</th>
                        <th>Service type</th>
                        <th>Witel</th>
                        <th>Work zone</th>
                        <th>Ticket status</th>
                        <th>Status date</th>
                        <th>Ticket id gamas</th>
                        <th>Reported by</th>
                        <th>Contact phone</th>
                        <th>Contact name</th>
                        <th>Contact email</th>
                        <th>Booking date</th>
                        <th>Description assignment</th>
                        <th>Reported priority</th>
                        <th>Source ticket</th>
                        <th>Subsidiary</th>
                        <th>External ticketid</th>
                        <th>Channel</th>
                        <th>Customer type</th>
                        <th>Closed by</th>
                        <th>Description closed by</th>
                        <th>Customer id</th>
                        <th>Description customerid</th>
                        <th>Service id</th>
                        <th>Service no</th>
                        <th>Slg</th>
                        <th>Technology</th>
                        <th>Lapul</th>
                        <th>Gaul</th>
                        <th>Onu rx</th>
                        <th>Pending reason</th>
                        <th>Date modified</th>
                        <th>Incident domain</th>
                        <th>Region</th>
                        <th>Symptom</th>
                        <th>Hierarchy path</th>
                        <th>Solution description</th>
                        <th>Description actualsolution</th>
                        <th>Kode produk</th>
                        <th>Perangkat</th>
                        <th>Technician</th>
                        <th>Pipe name</th>
                        <th>Worklog summary</th>
                        <th>Last update work log</th>
                        <th>Classification category</th>
                        <th>Realm</th>
                        <th>Related to gamas</th>
                        <th>Tsc result</th>
                        <th>Scc result</th>
                        <th>Ttr agent</th>
                        <th>Ttr mitra</th>
                        <th>Ttr nasional</th>
                        <th>Ttr pending</th>
                        <th>Ttr region</th>
                        <th>Ttr witel</th>
                        <th>Ttr end to end</th>
                        <th>Note</th>
                        <th>Guarantee status</th>
                        <th>Resolve date</th>
                        <th>Sn ont</th>
                        <th>Tipe ont</th>
                        <th>Manufacture ont</th>
                        <th>Impacted site</th>
                        <th>Cts cause</th>
                        <th>Cts resolution</th>
                        <th>Notes eskalasi</th>
                        <th>Rk information</th>
                        <th>External ticket tier3</th>
                        <th>Customer category</th>
                        <th>Classification path</th>
                        <th>Territory near end</th>
                        <th>Territory far end</th>
                        <th>Urgensi</th>
                        <th>Description urgensi</th>
                        <th>Scraped at</th>
                        <th>Scrape category</th>
                        <th width="100" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($records)): $no=1; foreach ($records as $r): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $no++; ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ticket_id']); ?></td>
                        <td class="align-middle"><?php echo formatTTR($r['ttr_customer']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['summary']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['reported_date']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['owner_group']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['owner']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['customer_segment']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['service_type']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['witel']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['work_zone']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ticket_status']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['status_date']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ticket_id_gamas']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['reported_by']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['contact_phone']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['contact_name']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['contact_email']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['booking_date']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['description_assignment']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['reported_priority']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['source_ticket']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['subsidiary']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['external_ticketid']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['channel']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['customer_type']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['closed_by']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['description_closed_by']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['customer_id']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['description_customerid']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['service_id']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['service_no']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['slg']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['technology']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['lapul']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['gaul']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['onu_rx']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['pending_reason']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['date_modified']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['incident_domain']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['region']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['symptom']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['hierarchy_path']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['solution_description']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['description_actualsolution']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['kode_produk']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['perangkat']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['technician']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['pipe_name']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['worklog_summary']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['last_update_work_log']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['classification_category']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['realm']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['related_to_gamas']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['tsc_result']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['scc_result']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_agent']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_mitra']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_nasional']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_pending']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_region']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_witel']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['ttr_end_to_end']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['note']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['guarantee_status']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['resolve_date']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['sn_ont']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['tipe_ont']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['manufacture_ont']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['impacted_site']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['cts_cause']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['cts_resolution']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['notes_eskalasi']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['rk_information']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['external_ticket_tier3']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['customer_category']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['classification_path']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['territory_near_end']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['territory_far_end']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['urgensi']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['description_urgensi']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['scraped_at']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['scrape_category']); ?></td>
                        <td class="text-right align-middle btn-action-group">
                            <button class="btn btn-xs" title="View Detail" onclick="viewDetail(<?php echo $r['ticket_id']; ?>)"><i class="fa fa-search-plus text-primary"></i></button>
                            <button class="btn btn-xs" title="Edit Data" onclick="editData(<?php echo $r['ticket_id']; ?>)"><i class="fa fa-pencil text-warning"></i></button>
                            <button class="btn btn-xs" title="Delete Data" onclick="deleteData(<?php echo $r['ticket_id']; ?>)"><i class="fa fa-trash text-danger"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header shadow-sm" style="border:0; background: #000000 !important; color: #ffffff !important;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity: 1;">&times;</button>
                <h4 class="modal-title" id="modalTitle" style="color:#fff; font-weight: 700;">Form Insera</h4>
            </div>
            <form id="formData">
                <div class="modal-body" style="padding: 25px;">
                    <input type="hidden" name="id" id="dataId">
                    <div class="form-group">
                        <label>Ttr customer <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_customer" id="ttr_customer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Summary <span class="text-danger">*</span></label>
                        <input type="text" name="summary" id="summary" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Reported date <span class="text-danger">*</span></label>
                        <input type="text" name="reported_date" id="reported_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Owner group <span class="text-danger">*</span></label>
                        <input type="text" name="owner_group" id="owner_group" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Owner <span class="text-danger">*</span></label>
                        <input type="text" name="owner" id="owner" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Customer segment <span class="text-danger">*</span></label>
                        <input type="text" name="customer_segment" id="customer_segment" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Service type <span class="text-danger">*</span></label>
                        <input type="text" name="service_type" id="service_type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Witel <span class="text-danger">*</span></label>
                        <input type="text" name="witel" id="witel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Work zone <span class="text-danger">*</span></label>
                        <input type="text" name="work_zone" id="work_zone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ticket status <span class="text-danger">*</span></label>
                        <input type="text" name="ticket_status" id="ticket_status" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status date <span class="text-danger">*</span></label>
                        <input type="text" name="status_date" id="status_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ticket id gamas <span class="text-danger">*</span></label>
                        <input type="text" name="ticket_id_gamas" id="ticket_id_gamas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Reported by <span class="text-danger">*</span></label>
                        <input type="text" name="reported_by" id="reported_by" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact phone <span class="text-danger">*</span></label>
                        <input type="tel" name="contact_phone" id="contact_phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact name <span class="text-danger">*</span></label>
                        <input type="text" name="contact_name" id="contact_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact email <span class="text-danger">*</span></label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Booking date <span class="text-danger">*</span></label>
                        <input type="text" name="booking_date" id="booking_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description assignment <span class="text-danger">*</span></label>
                        <input type="text" name="description_assignment" id="description_assignment" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Reported priority <span class="text-danger">*</span></label>
                        <input type="text" name="reported_priority" id="reported_priority" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Source ticket <span class="text-danger">*</span></label>
                        <input type="text" name="source_ticket" id="source_ticket" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Subsidiary <span class="text-danger">*</span></label>
                        <input type="text" name="subsidiary" id="subsidiary" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>External ticketid <span class="text-danger">*</span></label>
                        <input type="text" name="external_ticketid" id="external_ticketid" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Channel <span class="text-danger">*</span></label>
                        <input type="text" name="channel" id="channel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Customer type <span class="text-danger">*</span></label>
                        <input type="text" name="customer_type" id="customer_type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Closed by <span class="text-danger">*</span></label>
                        <input type="text" name="closed_by" id="closed_by" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description closed by <span class="text-danger">*</span></label>
                        <input type="text" name="description_closed_by" id="description_closed_by" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Customer id <span class="text-danger">*</span></label>
                        <input type="text" name="customer_id" id="customer_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description customerid <span class="text-danger">*</span></label>
                        <input type="text" name="description_customerid" id="description_customerid" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Service id <span class="text-danger">*</span></label>
                        <input type="text" name="service_id" id="service_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Service no <span class="text-danger">*</span></label>
                        <input type="text" name="service_no" id="service_no" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Slg <span class="text-danger">*</span></label>
                        <input type="text" name="slg" id="slg" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Technology <span class="text-danger">*</span></label>
                        <input type="text" name="technology" id="technology" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Lapul <span class="text-danger">*</span></label>
                        <input type="text" name="lapul" id="lapul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gaul <span class="text-danger">*</span></label>
                        <input type="text" name="gaul" id="gaul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Onu rx <span class="text-danger">*</span></label>
                        <input type="text" name="onu_rx" id="onu_rx" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pending reason <span class="text-danger">*</span></label>
                        <input type="text" name="pending_reason" id="pending_reason" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Date modified <span class="text-danger">*</span></label>
                        <input type="text" name="date_modified" id="date_modified" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Incident domain <span class="text-danger">*</span></label>
                        <input type="text" name="incident_domain" id="incident_domain" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Region <span class="text-danger">*</span></label>
                        <input type="text" name="region" id="region" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Symptom <span class="text-danger">*</span></label>
                        <input type="text" name="symptom" id="symptom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Hierarchy path <span class="text-danger">*</span></label>
                        <input type="text" name="hierarchy_path" id="hierarchy_path" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Solution description <span class="text-danger">*</span></label>
                        <input type="text" name="solution_description" id="solution_description" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description actualsolution <span class="text-danger">*</span></label>
                        <input type="text" name="description_actualsolution" id="description_actualsolution" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kode produk <span class="text-danger">*</span></label>
                        <input type="text" name="kode_produk" id="kode_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Perangkat <span class="text-danger">*</span></label>
                        <input type="text" name="perangkat" id="perangkat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Technician <span class="text-danger">*</span></label>
                        <input type="text" name="technician" id="technician" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pipe name <span class="text-danger">*</span></label>
                        <input type="text" name="pipe_name" id="pipe_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Worklog summary <span class="text-danger">*</span></label>
                        <input type="text" name="worklog_summary" id="worklog_summary" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Last update work log <span class="text-danger">*</span></label>
                        <input type="text" name="last_update_work_log" id="last_update_work_log" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Classification category <span class="text-danger">*</span></label>
                        <input type="text" name="classification_category" id="classification_category" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Realm <span class="text-danger">*</span></label>
                        <input type="text" name="realm" id="realm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Related to gamas <span class="text-danger">*</span></label>
                        <input type="text" name="related_to_gamas" id="related_to_gamas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tsc result <span class="text-danger">*</span></label>
                        <input type="text" name="tsc_result" id="tsc_result" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Scc result <span class="text-danger">*</span></label>
                        <input type="text" name="scc_result" id="scc_result" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr agent <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_agent" id="ttr_agent" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr mitra <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_mitra" id="ttr_mitra" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr nasional <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_nasional" id="ttr_nasional" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr pending <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_pending" id="ttr_pending" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr region <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_region" id="ttr_region" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr witel <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_witel" id="ttr_witel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ttr end to end <span class="text-danger">*</span></label>
                        <input type="text" name="ttr_end_to_end" id="ttr_end_to_end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Note <span class="text-danger">*</span></label>
                        <input type="text" name="note" id="note" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Guarantee status <span class="text-danger">*</span></label>
                        <input type="text" name="guarantee_status" id="guarantee_status" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Resolve date <span class="text-danger">*</span></label>
                        <input type="text" name="resolve_date" id="resolve_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Sn ont <span class="text-danger">*</span></label>
                        <input type="text" name="sn_ont" id="sn_ont" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe ont <span class="text-danger">*</span></label>
                        <input type="text" name="tipe_ont" id="tipe_ont" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Manufacture ont <span class="text-danger">*</span></label>
                        <input type="text" name="manufacture_ont" id="manufacture_ont" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Impacted site <span class="text-danger">*</span></label>
                        <input type="text" name="impacted_site" id="impacted_site" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cts cause <span class="text-danger">*</span></label>
                        <input type="text" name="cts_cause" id="cts_cause" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cts resolution <span class="text-danger">*</span></label>
                        <input type="text" name="cts_resolution" id="cts_resolution" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Notes eskalasi <span class="text-danger">*</span></label>
                        <input type="text" name="notes_eskalasi" id="notes_eskalasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Rk information <span class="text-danger">*</span></label>
                        <input type="text" name="rk_information" id="rk_information" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>External ticket tier3 <span class="text-danger">*</span></label>
                        <input type="text" name="external_ticket_tier3" id="external_ticket_tier3" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Customer category <span class="text-danger">*</span></label>
                        <input type="text" name="customer_category" id="customer_category" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Classification path <span class="text-danger">*</span></label>
                        <input type="text" name="classification_path" id="classification_path" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Territory near end <span class="text-danger">*</span></label>
                        <input type="text" name="territory_near_end" id="territory_near_end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Territory far end <span class="text-danger">*</span></label>
                        <input type="text" name="territory_far_end" id="territory_far_end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Urgensi <span class="text-danger">*</span></label>
                        <input type="text" name="urgensi" id="urgensi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description urgensi <span class="text-danger">*</span></label>
                        <input type="text" name="description_urgensi" id="description_urgensi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Scraped at <span class="text-danger">*</span></label>
                        <input type="text" name="scraped_at" id="scraped_at" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Scrape category <span class="text-danger">*</span></label>
                        <input type="text" name="scrape_category" id="scrape_category" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0" style="background: #000000 !important; padding: 20px;">
                    <button type="button" class="btn btn-flat" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--mac-border); border-radius: 8px; padding: 8px 20px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-flat" style="background: var(--mac-blue); color: #fff; border-radius: 8px; padding: 8px 25px; font-weight: 700;"><i class="fa fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImport" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header shadow-sm" style="border:0; background: #000000 !important; color: #ffffff !important;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity: 1;">&times;</button>
                <h4 class="modal-title" style="color:#fff; font-weight: 700;"><i class="fa fa-file-excel-o"></i> Import Data Insera</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="form-group" id="importStep1">
                    <label>Pilih File Excel (.xlsx / .xls)</label>
                    <input type="file" id="excelFile" class="form-control" accept=".xlsx, .xls">
                    <p class="help-block">Gunakan baris pertama sebagai Header kolom.</p>
                </div>
                <div id="importStep2" style="display:none;">
                    <label>Pratinjau Data (Review & Verifikasi)</label>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-bordered table-condensed table-striped" id="tblPreview">
                            <thead><tr class="bg-gray-light"></tr></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0" style="background: #000000 !important; padding: 20px;">
                <button type="button" class="btn btn-flat" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--mac-border); border-radius: 8px; padding: 8px 20px;" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-flat" id="btnProcessImport" style="display:none; background: var(--mac-green); color: #fff; border-radius: 8px; padding: 8px 25px; font-weight: 700;"><i class="fa fa-check"></i> Simpan Semua Data</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/starter_kit/vendor/xlsx.full.min.js'); ?>"></script>
<script>
var tblData;
$(function(){
    tblData = $('#tblData').DataTable({
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>',
        "language": { "search": "Cari:" }
    });
});

function showAddModal() {
    $('#modalTitle').text('Tambah Data Insera');
    $('#formData')[0].reset();
    $('#dataId').val('');
    $('#modalForm').modal('show');
}

function editData(id) {
    $.post(BASE_URL + 'admin/insera/get_data', {id: id}, function(res) {
        var d = JSON.parse(res);
        $('#modalTitle').text('Edit Data Insera');
        $('#dataId').val(d.ticket_id);
        $('#ttr_customer').val(d.ttr_customer);
        $('#summary').val(d.summary);
        $('#reported_date').val(d.reported_date);
        $('#owner_group').val(d.owner_group);
        $('#owner').val(d.owner);
        $('#customer_segment').val(d.customer_segment);
        $('#service_type').val(d.service_type);
        $('#witel').val(d.witel);
        $('#work_zone').val(d.work_zone);
        $('#ticket_status').val(d.ticket_status);
        $('#status_date').val(d.status_date);
        $('#ticket_id_gamas').val(d.ticket_id_gamas);
        $('#reported_by').val(d.reported_by);
        $('#contact_phone').val(d.contact_phone);
        $('#contact_name').val(d.contact_name);
        $('#contact_email').val(d.contact_email);
        $('#booking_date').val(d.booking_date);
        $('#description_assignment').val(d.description_assignment);
        $('#reported_priority').val(d.reported_priority);
        $('#source_ticket').val(d.source_ticket);
        $('#subsidiary').val(d.subsidiary);
        $('#external_ticketid').val(d.external_ticketid);
        $('#channel').val(d.channel);
        $('#customer_type').val(d.customer_type);
        $('#closed_by').val(d.closed_by);
        $('#description_closed_by').val(d.description_closed_by);
        $('#customer_id').val(d.customer_id);
        $('#description_customerid').val(d.description_customerid);
        $('#service_id').val(d.service_id);
        $('#service_no').val(d.service_no);
        $('#slg').val(d.slg);
        $('#technology').val(d.technology);
        $('#lapul').val(d.lapul);
        $('#gaul').val(d.gaul);
        $('#onu_rx').val(d.onu_rx);
        $('#pending_reason').val(d.pending_reason);
        $('#date_modified').val(d.date_modified);
        $('#incident_domain').val(d.incident_domain);
        $('#region').val(d.region);
        $('#symptom').val(d.symptom);
        $('#hierarchy_path').val(d.hierarchy_path);
        $('#solution_description').val(d.solution_description);
        $('#description_actualsolution').val(d.description_actualsolution);
        $('#kode_produk').val(d.kode_produk);
        $('#perangkat').val(d.perangkat);
        $('#technician').val(d.technician);
        $('#pipe_name').val(d.pipe_name);
        $('#worklog_summary').val(d.worklog_summary);
        $('#last_update_work_log').val(d.last_update_work_log);
        $('#classification_category').val(d.classification_category);
        $('#realm').val(d.realm);
        $('#related_to_gamas').val(d.related_to_gamas);
        $('#tsc_result').val(d.tsc_result);
        $('#scc_result').val(d.scc_result);
        $('#ttr_agent').val(d.ttr_agent);
        $('#ttr_mitra').val(d.ttr_mitra);
        $('#ttr_nasional').val(d.ttr_nasional);
        $('#ttr_pending').val(d.ttr_pending);
        $('#ttr_region').val(d.ttr_region);
        $('#ttr_witel').val(d.ttr_witel);
        $('#ttr_end_to_end').val(d.ttr_end_to_end);
        $('#note').val(d.note);
        $('#guarantee_status').val(d.guarantee_status);
        $('#resolve_date').val(d.resolve_date);
        $('#sn_ont').val(d.sn_ont);
        $('#tipe_ont').val(d.tipe_ont);
        $('#manufacture_ont').val(d.manufacture_ont);
        $('#impacted_site').val(d.impacted_site);
        $('#cts_cause').val(d.cts_cause);
        $('#cts_resolution').val(d.cts_resolution);
        $('#notes_eskalasi').val(d.notes_eskalasi);
        $('#rk_information').val(d.rk_information);
        $('#external_ticket_tier3').val(d.external_ticket_tier3);
        $('#customer_category').val(d.customer_category);
        $('#classification_path').val(d.classification_path);
        $('#territory_near_end').val(d.territory_near_end);
        $('#territory_far_end').val(d.territory_far_end);
        $('#urgensi').val(d.urgensi);
        $('#description_urgensi').val(d.description_urgensi);
        $('#scraped_at').val(d.scraped_at);
        $('#scrape_category').val(d.scrape_category);
        $('#modalForm').modal('show');
    });
}

$('#formData').submit(function(e) {
    e.preventDefault();
    App.showLoader();
    $.post(BASE_URL + 'admin/insera/save', $(this).serialize(), function(res) {
        App.hideLoader();
        var r = JSON.parse(res);
        if (r.status == 'success') {
            $('#modalForm').modal('hide');
            App.toast(r.message, 'success');
            setTimeout(function() { location.reload(); }, 1500);
        } else {
            App.alert('Error', r.message, 'error');
        }
    }).fail(function() {
        App.hideLoader();
        App.alert('Error', 'Koneksi ke server terputus.', 'error');
    });
});

function deleteData(id) {
    App.confirm('Hapus Data?', 'Konfirmasi penghapusan data ini. Data akan dipindahkan ke Recycle Bin.', function() {
        $.post(BASE_URL + 'admin/insera/delete', {id: id}, function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                setTimeout(function() { location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    });
}

var importedData = [];
function showImportModal() {
    $('#modalImport').modal('show');
    $('#importStep1').show();
    $('#importStep2').hide();
    $('#btnProcessImport').hide();
    $('#excelFile').val('');
}

$('#excelFile').change(function(e) {
    var reader = new FileReader();
    reader.readAsArrayBuffer(e.target.files[0]);
    reader.onload = function(e) {
        var data = new Uint8Array(reader.result);
        var workbook = XLSX.read(data, {type: 'array'});
        var sheetName = workbook.SheetNames[0];
        var sheet = workbook.Sheets[sheetName];
        var json = XLSX.utils.sheet_to_json(sheet);
        if (json.length > 0) {
            importedData = json;
            $('#importStep1').hide();
            $('#importStep2').show();
            $('#btnProcessImport').show();
            var head = $('#tblPreview thead tr').empty();
            var body = $('#tblPreview tbody').empty();
            // Map headers
            Object.keys(json[0]).forEach(k => head.append('<th>' + k + '</th>'));
            // Show first 10 rows as preview
            json.slice(0, 10).forEach(row => {
                var tr = $('<tr>');
                Object.values(row).forEach(v => tr.append('<td>' + v + '</td>'));
                body.append(tr);
            });
            if (json.length > 10) body.append('<tr><td colspan="99" class="text-center text-muted italic">... ' + (json.length - 10) + ' data lainnya tidak ditampilkan di pratinjau ...</td></tr>');
        }
    }
});

$('#btnProcessImport').click(function() {
    App.confirm('Simpan Data Import?', 'Anda akan menyimpan ' + importedData.length + ' data ke database.', function() {
        App.showLoader();
        $.post(BASE_URL + 'admin/insera/import_excel', {data: importedData}, function(res) {
            App.hideLoader();
            var r = JSON.parse(res);
            if (r.status == 'success') {
                $('#modalImport').modal('hide');
                App.alert('Berhasil', r.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                App.alert('Gagal', r.message, 'error');
            }
        });
    }, 'primary');
});

function exportExcel() {
    var wb = XLSX.utils.book_new();
    var ws_data = [];
    var headers = [];
    $('#tblData thead th').each(function(index) {
        if (index < $('#tblData thead th').length - 1) headers.push($(this).text().trim());
    });
    ws_data.push(headers);
    var filteredData = tblData.rows({ search: 'applied' }).data().toArray();
    for (var i = 0; i < filteredData.length; i++) {
        var rowData = [];
        for (var j = 0; j < headers.length; j++) {
            rowData.push($('<div>').html(filteredData[i][j]).text().trim());
        }
        ws_data.push(rowData);
    }
    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, 'Data Insera');
    XLSX.writeFile(wb, 'Export_Data_Insera_' + new Date().getTime() + '.xlsx');
}
</script>
