<style>
    .vault-sidebar { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .vault-nav { list-style: none; padding: 0; margin: 0; }
    .vault-nav li { border-bottom: 1px solid #f1f5f9; }
    .vault-nav li:last-child { border-bottom: none; }
    .vault-nav a { display: flex; align-items: center; padding: 15px 20px; color: #64748b; text-decoration: none; transition: all 0.2s; font-weight: 500; }
    .vault-nav a i { width: 24px; font-size: 16px; margin-right: 12px; transition: all 0.2s; }
    .vault-nav li.active a { background: #f8fafc; color: #3b82f6; border-left: 4px solid #3b82f6; padding-left: 16px; font-weight: 700; }
    .vault-nav li.active i { color: #3b82f6; }
    .vault-nav a:hover:not(.active) { background: #fdfdfd; color: #1e293b; padding-left: 25px; }
    
    .badge-vault-count { margin-left: auto; background: #f1f5f9; color: #64748b; font-size: 11px; padding: 2px 8px; border-radius: 50px; }
    .active .badge-vault-count { background: #dbeafe; color: #2563eb; }

    .vault-empty { padding: 80px 20px; text-align: center; color: #94a3b8; }
    .vault-empty i { font-size: 64px; color: #e2e8f0; margin-bottom: 20px; }

    .table-vault thead th { background: #f8fafc; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 12px 15px; border-bottom: 2px solid #e2e8f0; }
    .table-vault td { padding: 15px; vertical-align: middle !important; border-bottom: 1px solid #f1f5f9; }
    .table-vault tr:hover td { background: #fdfdfd; }

    .mod-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 15px; }
    .bg-soft-blue { background: #eff6ff; color: #3b82f6; }
    .bg-soft-green { background: #f0fdf4; color: #22c55e; }
    .bg-soft-orange { background: #fff7ed; color: #f59e0b; }
    .bg-soft-gray { background: #f8fafc; color: #64748b; }

    .item-main { color: #1e293b; font-weight: 700; font-size: 14px; margin-bottom: 2px; }
    .item-sub { color: #64748b; font-size: 12px; }

    .btn-restore-premium { 
        background: #fff; border: 1px solid #3b82f6; color: #3b82f6; border-radius: 6px; 
        padding: 6px 15px; font-weight: 600; font-size: 12px; transition: all 0.2s; margin-right: 5px;
    }
    .btn-restore-premium:hover { background: #3b82f6; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2); }
    
    .btn-vaporize { 
        background: #fff; border: 1px solid #ef4444; color: #ef4444; border-radius: 6px; 
        padding: 6px 15px; font-weight: 600; font-size: 12px; transition: all 0.2s;
    }
    .btn-vaporize:hover { background: #ef4444; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); }
</style>

<div class="row">
    <!-- Navigation Vault -->
    <div class="col-md-3">
        <div class="vault-sidebar shadow-sm">
            <div style="padding: 20px; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                <h5 style="margin:0; font-weight: 700; color: #1e293b;"><i class="fa fa-archive text-primary"></i> Data Archive</h5>
                <p class="text-muted small no-margin">Manage all soft-deleted entities.</p>
            </div>
            <div style="max-height: 450px; overflow-y: auto;">
                <ul class="vault-nav" id="filterList">
                    <li class="active">
                        <a href="#" data-type="all">
                            <i class="fa fa-th-large"></i> Overview
                            <span class="badge-vault-count" id="cnt-all"><?php echo $total; ?></span>
                        </a>
                    </li>
                    <?php if (isset($tables)): foreach ($tables as $t): 
                        $icon = 'fa-database';
                        if ($t == 'users') $icon = 'fa-users';
                        if ($t == 'roles') $icon = 'fa-shield';
                        if ($t == 'menu') $icon = 'fa-bars';
                        if ($t == 'jabatan') $icon = 'fa-briefcase';
                    ?>
                    <li>
                        <a href="#" data-type="<?php echo $t; ?>">
                            <i class="fa <?php echo $icon; ?>"></i> <?php echo ucwords(str_replace('_', ' ', $t)); ?>
                            <span class="badge-vault-count vault-item-count" data-counter-type="<?php echo $t; ?>"><?php echo isset($counts[$t]) ? $counts[$t] : 0; ?></span>
                        </a>
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
        
        <div class="well no-shadow border-0" style="margin-top: 25px; background: #fffbeb; border: 1px solid #fde68a;">
            <h5 style="color: #92400e; font-weight: 700; margin-top:0;"><i class="fa fa-lightbulb-o"></i> Restoration Note</h5>
            <p class="small text-muted" style="color: #b45309 !important;">Items recovered from this vault will be immediately reintegrated into their respective modules without data loss.</p>
        </div>
    </div>

    <!-- Results Area -->
    <div class="col-md-9">
        <div class="box box-primary border-0 shadow-sm">
            <div class="box-header with-border" style="padding: 20px;">
                <h3 class="box-title" style="font-weight: 700; color: #1e293b;"><i class="fa fa-trash-o text-muted"></i> <span id="tableTitle">Inventory of Deleted Items</span></h3>
                <div class="pull-right">
                    <button type="button" class="btn btn-default btn-sm btn-flat" style="margin-right: 5px;" onclick="reloadTable()" title="Refresh Inventory"><i class="fa fa-refresh"></i> Sync</button>
                    <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="emptyVault()" title="Permanently Delete All"><i class="fa fa-fire"></i> Empty Vault</button>
                </div>
            </div>
            <div class="box-body no-padding" style="min-height: 400px;">
                <div class="table-responsive">
                    <table class="table table-vault no-margin" id="tblRecycle">
                        <thead>
                            <tr>
                                <th>Category & Identity</th>
                                <th>Operational Detail</th>
                                <th>Removal Timestamp</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="recycleBody">
                            <!-- Loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Skeleton / Empty State -->
                <div id="vaultEmpty" class="vault-empty" style="display:none;">
                    <i class="fa fa-trash-o"></i>
                    <h4>Pristine Environment</h4>
                    <p>There are no temporarily deleted records in this category.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var currentType = 'all';

$(function() {
    loadRecycleData('all');

    $('#filterList a').click(function(e) {
        e.preventDefault();
        $('#filterList li').removeClass('active');
        $(this).parent().addClass('active');
        
        currentType = $(this).data('type');
        loadRecycleData(currentType);
    });
});

function reloadTable() {
    loadRecycleData(currentType);
}

function updateLocalCountArray(type) {
    var $el = $('.vault-item-count[data-counter-type="' + type + '"]');
    if ($el.length) {
        var current = parseInt($el.text());
        if(current > 0) $el.text(current - 1);
    }
    
    var total = 0;
    $('.vault-item-count').each(function() {
        total += parseInt($(this).text());
    });
    $('#cnt-all').text(total);
}

function loadRecycleData(type) {
    $('#recycleBody').css('opacity', '0.5');
    $('#vaultEmpty').hide();
    
    $.get(BASE_URL + 'admin/recycle_bin/get_data/' + type, function(res) {
        $('#recycleBody').css('opacity', '1');
        var data = JSON.parse(res);
        var html = '';
        
        if (data.length == 0) {
            $('#tblRecycle').hide();
            $('#vaultEmpty').show();
        } else {
            $('#tblRecycle').show();
            $('#vaultEmpty').hide();
            
            data.forEach(function(item) {
                var iconClass = 'bg-soft-gray';
                var icon = 'fa-database';
                var itemType = item._type || type;
                var info = '<span class="text-muted">Table Source:</span> ' + itemType.toUpperCase();

                if (itemType == 'users') { iconClass = 'bg-soft-blue'; icon = 'fa-user'; }
                else if (itemType == 'menu') { iconClass = 'bg-soft-green'; icon = 'fa-bars'; }
                else if (itemType == 'roles') { iconClass = 'bg-soft-orange'; icon = 'fa-shield'; }
                else if (itemType == 'jabatan') { iconClass = 'bg-soft-orange'; icon = 'fa-briefcase'; }

                html += '<tr>';
                html += '  <td>';
                html += '    <div style="display:flex; align-items:center;">';
                html += '      <div class="mod-icon ' + iconClass + '"><i class="fa ' + icon + '"></i></div>';
                html += '      <div>';
                html += '        <div class="item-main">' + item._main + '</div>';
                html += '        <div class="item-sub">' + item._sub + '</div>';
                html += '      </div>';
                html += '    </div>';
                html += '  </td>';
                html += '  <td>' + info + '</td>';
                html += '  <td class="text-muted small"><i class="fa fa-calendar-times-o"></i> ' + item.deleted_at + '</td>';
                html += '  <td class="text-center" style="white-space:nowrap;">';
                html += '    <button class="btn-restore-premium" onclick="restoreData(' + item._pk_id + ', \'' + itemType + '\')" title="Restore"><i class="fa fa-history"></i> Restore</button>';
                html += '    <button class="btn-vaporize" onclick="vaporizeData(' + item._pk_id + ', \'' + itemType + '\')" title="Vaporize"><i class="fa fa-trash"></i> Del</button>';
                html += '  </td>';
                html += '</tr>';
            });
        }
        $('#recycleBody').html(html);
    });
}

function restoreData(id, type) {
    App.confirm('Initiate Data Restoration?', 'This object will be removed from the vault and return to its original module.', function() {
        $.post(BASE_URL + 'admin/recycle_bin/restore', {id: id, type: type}, function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                updateLocalCountArray(type);
                reloadTable();
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    }, 'info');
}

function vaporizeData(id, type) {
    App.confirm('Warning: Permanent Deletion', 'This action cannot be undone. The data will be physically removed from the server (Vaporized). Proceed?', function() {
        $.post(BASE_URL + 'admin/recycle_bin/hard_delete', {id: id, type: type}, function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                updateLocalCountArray(type);
                reloadTable();
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    }, 'danger');
}

function emptyVault() {
    App.confirm('CRITICAL ACTION: Empty Global Vault?', 'You are about to permanently obliterate ALL items currently in the Recycle Bin across all modules. This action is absolutely irreversible. Are you sure?', function() {
        $.post(BASE_URL + 'admin/recycle_bin/empty_bin', {}, function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    }, 'danger');
}
</script>
