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

    body { background-color: var(--mac-bg) !important; color: var(--mac-text) !important; }
    .content-wrapper { background-color: var(--mac-bg) !important; }

    .log-filter-box { 
        background: var(--mac-card) !important; 
        border-radius: 12px; 
        border: 1px solid var(--mac-border) !important; 
        padding: 20px; 
        margin-bottom: 25px; 
        box-shadow: var(--mac-shadow) !important; 
        color: var(--mac-text) !important;
    }
    
    .event-badge { padding: 4px 12px; border-radius: 50px; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 5px; border-width: 1px; border-style: solid; }
    .ev-create { background: rgba(48, 209, 88, 0.15) !important; color: var(--mac-green); border-color: rgba(48, 209, 88, 0.3) !important; }
    .ev-update { background: rgba(10, 132, 255, 0.15) !important; color: var(--mac-blue); border-color: rgba(10, 132, 255, 0.3) !important; }
    .ev-delete { background: rgba(255, 69, 58, 0.15) !important; color: var(--mac-red); border-color: rgba(255, 69, 58, 0.3) !important; }
    .ev-login { background: rgba(255, 255, 255, 0.1) !important; color: #fff; border-color: rgba(255, 255, 255, 0.2) !important; }
    .ev-logout { background: rgba(255, 255, 255, 0.05) !important; color: var(--mac-text-dim); border-color: rgba(255, 255, 255, 0.1) !important; }
    
    .form-control { background: #1c1c1e !important; border: 1px solid var(--mac-border) !important; color: #fff !important; }

    /* Table Styling */
    .box { background: var(--mac-card) !important; border-radius: 12px; border: 1px solid var(--mac-border) !important; overflow: hidden; box-shadow: var(--mac-shadow) !important; }
    .table { color: var(--mac-text) !important; }
    #tblLogs thead tr, #tblLogs thead th { background: #000000 !important; color: #fff !important; border-color: var(--mac-border) !important; text-transform: uppercase; font-size: 11px; }
    .table-hover > tbody > tr:hover { background-color: rgba(255, 255, 255, 0.05) !important; }

    /* Export Buttons Style */
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

    .dt-buttons .btn:hover {
        background: #2c2c2e !important;
        border-color: var(--mac-blue) !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
    }

    /* Modal Analysis */
    .modal-content { background: #000000 !important; border: 1px solid var(--mac-border) !important; border-radius: 12px !important; color: #fff !important; }
    .modal-header { background: #000000 !important; border-bottom: 1px solid var(--mac-border) !important; }
    .modal-body { background: #000000 !important; }
    .modal-footer { background: #000000 !important; border-top: 1px solid var(--mac-border) !important; }

    .diff-table th { background: rgba(255,255,255,0.05); color: var(--mac-text-dim); border-bottom: 1px solid var(--mac-border); }
    .diff-table td { border-bottom: 1px solid var(--mac-border); color: #fff; }
    .col-attr { color: var(--mac-blue); }
    .col-old { color: var(--mac-red); background: rgba(255, 69, 58, 0.05); }
    .col-new { color: var(--mac-green); background: rgba(48, 209, 88, 0.05); }
</style>

<!-- Top Statistics or Filter -->
<div class="log-filter-box">
    <div class="row">
        <div class="col-md-5">
            <h3 style="margin:0 0 5px 0; font-weight: 700; color: #fff;">Event Monitor</h3>
            <p class="text-muted small">Real-time stream of system security and data events.</p>
        </div>
        <div class="col-md-12" style="margin-top: 15px;">
            <div class="row">
                <div class="col-md-3">
                    <label class="small text-muted">Filter by Module</label>
                    <select id="moduleFilter" class="form-control btn-flat shadow-none border-gray">
                        <option value="">All Logical Modules</option>
                        <?php if (isset($modules)): foreach ($modules as $m): ?>
                        <option value="<?php echo $m['module']; ?>"><?php echo strtoupper($m['module']); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Filter by Action</label>
                    <select id="actionFilter" class="form-control btn-flat shadow-none border-gray">
                        <option value="">All Interaction Types</option>
                        <option value="CREATE">CREATE (New Entry)</option>
                        <option value="UPDATE">UPDATE (Modification)</option>
                        <option value="DELETE">DELETE (Removal)</option>
                        <option value="LOGIN">LOGIN (Auth Success)</option>
                        <option value="LOGOUT">LOGOUT (Session End)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Date From</label>
                    <input type="date" id="dateFrom" class="form-control btn-flat border-gray">
                </div>
                <div class="col-md-3">
                    <label class="small text-muted">Date To</label>
                    <input type="date" id="dateTo" class="form-control btn-flat border-gray">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Table -->
<div class="box box-primary border-0 shadow-sm">
    <div class="box-body no-padding">
        <table id="tblLogs" class="table table-hover align-middle" style="width:100%; border-top: 1px solid #f1f5f9;">
            <thead>
                <tr class="bg-gray-light">
                    <th style="padding-left: 20px;">Event Timestamp</th>
                    <th>Context Scope</th>
                    <th>Target Object</th>
                    <th>Action Signature</th>
                    <th>Authorized Actor</th>
                    <th width="60" class="text-center">Review</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Analysis Detail -->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-navy shadow-sm">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" style="color:#fff; font-weight: 600;"><i class="fa fa-terminal"></i> Forensic Event Analysis</h4>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <!-- Event Header Info -->
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-3">
                        <span class="text-muted small d-block">CHRONOLOGY</span>
                        <strong id="detTimestamp"></strong>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block">SIGNATURE</span>
                        <div id="detAction"></div>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block">COMPONENT</span>
                        <strong id="detModule"></strong>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block">NETWORK ORIGIN</span>
                        <code id="detIp"></code>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-12">
                        <span class="text-muted small d-block">DEVICE SIGNATURE (USER AGENT)</span>
                        <div id="detUserAgent" style="font-size: 11px; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; color: #64748b; word-break: break-all;"></div>
                    </div>
                </div>

                <!-- Attribute Comparison -->
                <div id="attributeAnalysis">
                    <h5 style="font-weight: 700; color: #1e293b; margin-bottom: 15px;">
                        <i class="fa fa-sliders text-blue"></i> Attribute Mutation Analysis
                    </h5>
                    <div class="table-responsive">
                        <table class="diff-table">
                            <thead>
                                <tr>
                                    <th>Attribute</th>
                                    <th>Baseline (Before)</th>
                                    <th>Final State (After)</th>
                                </tr>
                            </thead>
                            <tbody id="diffBody">
                                <!-- JS Injection -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="noObjectInfo" style="display:none; padding: 40px;" class="text-center text-muted border-gray-dashed">
                    <i class="fa fa-info-circle fa-2x"></i><br>
                    This interaction is a stateless event (Auth/Session) and does not involve data object mutation.
                </div>

                <!-- Raw Scheme Toggle -->
                <div style="margin-top: 30px;">
                    <button type="button" class="btn btn-xs btn-default btn-flat" onclick="$('#rawPayloads').toggle()">
                        <i class="fa fa-code"></i> Inspect Raw XML/JSON Structure
                    </button>
                    <div id="rawPayloads" style="display:none;">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="small font-bold text-muted mt-15">EVIDENCE BEFORE</h6>
                                <pre id="dataBefore" class="raw-json-block"></pre>
                            </div>
                            <div class="col-md-6">
                                <h6 class="small font-bold text-muted mt-15">EVIDENCE AFTER</h6>
                                <pre id="dataAfter" class="raw-json-block"></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0" style="background: #000000 !important; padding: 20px;">
                <button type="button" class="btn btn-flat" style="background: #1c1c1e; color: #fff; border: 1px solid var(--mac-border); border-radius: 8px; padding: 8px 25px; font-weight: 700; transition: 0.3s;" data-dismiss="modal">Close Investigation</button>
            </div>
        </div>
    </div>
</div>

<script>
var logTable;
$(function(){
    logTable = $('#tblLogs').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: BASE_URL + 'admin/activity_log/get_datatable',
            type: 'POST',
            data: function(d){
                d.module_filter = $('#moduleFilter').val();
                d.action_filter = $('#actionFilter').val();
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
            }
        },
        columnDefs: [
            {
                targets: 0,
                render: function(data, type, row) {
                    return '<div style="padding-left: 10px;"><i class="fa fa-clock-o text-gray"></i> ' + data + '</div>';
                }
            },
            {
                targets: 3, // Action
                render: function(data, type, row) {
                    var cls = 'ev-logout';
                    var icon = 'fa-circle-o';
                    if (data == 'CREATE') { cls = 'ev-create'; icon = 'fa-plus-circle'; }
                    if (data == 'UPDATE') { cls = 'ev-update'; icon = 'fa-pencil-square'; }
                    if (data == 'DELETE') { cls = 'ev-delete'; icon = 'fa-trash-o'; }
                    if (data == 'LOGIN') { cls = 'ev-login'; icon = 'fa-sign-in'; }
                    if (data == 'LOGOUT') { cls = 'ev-logout'; icon = 'fa-sign-out'; }
                    return '<span class="event-badge ' + cls + '"><i class="fa ' + icon + '"></i> ' + data + '</span>';
                }
            },
            {
                targets: 4, // Actor
                render: function(data, type, row) {
                    var raw = $('<div>').html(data);
                    var name = raw.find('strong').text() || 'System';
                    var initial = name.charAt(0).toUpperCase();
                    var color = name == 'System' ? '#64748b' : '#3b82f6';
                    return `
                        <div class="user-actor">
                            <div class="actor-avatar" style="background:${color}">${initial}</div>
                            <div>
                                <div style="font-weight:700; color:#1e293b">${name}</div>
                                <div class="small text-muted">${raw.find('small').text() || '127.0.0.1'}</div>
                            </div>
                        </div>
                    `;
                }
            },
            {
                targets: 5,
                className: 'text-center',
                orderable: false,
                render: function(data, type, row) {
                    return `<button class="btn btn-xs btn-flat" style="background: rgba(255,255,255,0.05); border: 1px solid var(--mac-border); border-radius: 6px; padding: 4px 10px;" title="Review Detail">${data.replace('btn-info', '').replace('fa-eye', 'fa-search-plus text-primary')}</button>`;
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>',
        buttons: [
            { extend: 'excel', className: 'btn btn-flat', text: '<i class="fa fa-file-excel-o text-success"></i> Excel' },
            { extend: 'pdf', className: 'btn btn-flat', text: '<i class="fa fa-file-pdf-o text-danger"></i> PDF' }
        ]
    });

    $('#moduleFilter, #actionFilter, #dateFrom, #dateTo').change(function(){ logTable.draw(); });
});

$(document).on('click', '.btn-detail', function(){
    var id = $(this).data('id');
    $('#rawPayloads').hide();
    
    App.alert('Tracing chronology...', 'Accessing secured interaction logs.', 'info');

    $.get(BASE_URL+'admin/activity_log/get_detail', {id:id}, function(res){
        Swal.close();
        var log = JSON.parse(res);
        
        // Modal Header Info
        $('#detTimestamp').text(log.created_at);
        $('#detModule').text(log.module);
        $('#detIp').text(log.ip_address);
        $('#detUserAgent').text(log.user_agent || 'N/A');
        
        var actCls = 'ev-logout';
        if (log.action == 'CREATE') actCls = 'ev-create';
        if (log.action == 'UPDATE') actCls = 'ev-update';
        if (log.action == 'DELETE') actCls = 'ev-delete';
        if (log.action == 'LOGIN') actCls = 'ev-login';
        if (log.action == 'LOGOUT') actCls = 'ev-logout';
        $('#detAction').html('<span class="event-badge ' + actCls + '">' + log.action + '</span>');

        // Payloads
        $('#dataBefore').text(log.data_before ? JSON.stringify(log.data_before, null, 2) : '— NIL PAYLOAD —');
        $('#dataAfter').text(log.data_after ? JSON.stringify(log.data_after, null, 2) : '— NIL PAYLOAD —');
        
        // Smart Diffing
        var html = '';
        var before = log.data_before || {};
        var after = log.data_after || {};
        var keys = [...new Set([...Object.keys(before), ...Object.keys(after)])];
        
        if(keys.length == 0) {
            $('#attributeAnalysis').hide();
            $('#noObjectInfo').show();
        } else {
            $('#attributeAnalysis').show();
            $('#noObjectInfo').hide();
            
            keys.forEach(function(key){
                if(['id', 'updated_at', 'created_at', 'password'].includes(key)) return;
                
                var valBefore = before[key] !== undefined ? (before[key] !== null ? before[key] : 'NULL') : 'N/A';
                var valAfter = after[key] !== undefined ? (after[key] !== null ? after[key] : 'NULL') : 'N/A';
                
                var isChanged = String(valBefore) !== String(valAfter);
                if(isChanged) {
                    html += '<tr>';
                    html += '  <td class="col-attr">' + key.replace(/_/g, ' ').toUpperCase() + '</td>';
                    html += '  <td class="col-old">' + (typeof valBefore === 'object' ? JSON.stringify(valBefore) : valBefore) + '</td>';
                    html += '  <td class="col-new">' + (typeof valAfter === 'object' ? JSON.stringify(valAfter) : valAfter) + '</td>';
                    html += '</tr>';
                }
            });
            
            if(html == '') {
                html = '<tr><td colspan="3" class="text-center p-20 text-muted italic">No attribute mutations detected in this event.</td></tr>';
            }
        }
        
        $('#diffBody').html(html);
        $('#modalDetail').modal('show');
    });
});
</script>

