<style>
    .log-filter-box { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    
    .event-badge { padding: 4px 12px; border-radius: 6px; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 5px; }
    .ev-create { background: #ecfdf5; color: #059669; }
    .ev-update { background: #fffbe6; color: #d97706; }
    .ev-delete { background: #fef2f2; color: #dc2626; }
    .ev-login { background: #eff6ff; color: #2563eb; }
    .ev-logout { background: #f8fafc; color: #475569; }
    
    .user-actor { display: flex; align-items: center; gap: 10px; }
    .actor-avatar { width: 32px; height: 32px; background: #3b82f6; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; }
    
    .diff-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .diff-table th { background: #f8fafc; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 12px 15px; border-bottom: 2px solid #e2e8f0; }
    .diff-table td { padding: 12px 15px; border-bottom: 1px solid #f1f5f9; vertical-align: top; font-size: 13px; }
    .col-attr { font-weight: 600; color: #1e293b; width: 25%; }
    .col-old { color: #dc2626; background: #fff5f5; width: 37.5%; }
    .col-new { color: #059669; background: #f0fdf4; font-weight: 600; width: 37.5%; }
    
    .raw-json-block { background: #1e293b; color: #94a3b8; padding: 15px; border-radius: 8px; font-family: 'Monaco', 'Consolas', monospace; font-size: 11px; margin-top: 15px; max-height: 250px; overflow: auto; }
</style>

<!-- Top Statistics or Filter -->
<div class="log-filter-box">
    <div class="row">
        <div class="col-md-5">
            <h3 style="margin:0 0 5px 0; font-weight: 700; color: #1e293b;">Event Monitor</h3>
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
            <div class="modal-footer bg-gray-light">
                <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">Close Investigation</button>
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
                    return data.replace('btn-info', 'btn-default btn-flat').replace('fa-eye', 'fa-search-plus text-primary');
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        dom: '<"row"<"col-sm-6"B><"col-sm-6"f>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>',
        buttons: [
            { extend: 'excel', className: 'btn btn-default btn-sm btn-flat' },
            { extend: 'pdf', className: 'btn btn-default btn-sm btn-flat' }
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

