<style>
    .backup-wrapper { display: flex; gap: 30px; }
    .backup-sidebar { width: 300px; flex-shrink: 0; }
    .backup-main { flex-grow: 1; }

    .nav-vault { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; padding: 8px 0; }
    .nav-vault li { padding: 2px 10px; }
    .nav-vault li a { 
        display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; 
        color: #64748b; font-weight: 500; transition: all 0.2s;
    }
    .nav-vault li a i { width: 20px; font-size: 16px; margin-right: 12px; }
    .nav-vault li.active a { background: #eff6ff; color: #3b82f6; font-weight: 700; }
    .nav-vault li a:hover:not(.active) { background: #f8fafc; color: #1e293b; padding-left: 20px; }

    .snapshot-status-card { 
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 25px; 
        margin-top: 25px; text-align: center; position: relative; overflow: hidden;
    }
    .snapshot-status-card::before { 
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: #3b82f6; 
    }
    .snapshot-icon { font-size: 40px; color: #dbeafe; margin-bottom: 15px; }
    .snapshot-date { font-size: 20px; font-weight: 800; color: #1e293b; margin-bottom: 5px; }
    .snapshot-label { color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }

    .history-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .history-header { padding: 20px 25px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
    .history-header h4 { margin: 0; font-weight: 700; color: #1e293b; }

    .table-history { width: 100%; border-collapse: separate; border-spacing: 0; }
    .table-history thead th { background: #f8fafc; padding: 12px 20px; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
    .table-history td { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .table-history tr:hover td { background: #fcfcfc; }

    .badge-backup { padding: 4px 10px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .badge-manual { background: #dbeafe; color: #2563eb; }
    .badge-auto { background: #dcfce7; color: #166534; }

    .init-zone { border: 2px dashed #e2e8f0; border-radius: 16px; padding: 60px 20px; text-align: center; background: #f8fafc; }
    .init-icon { width: 80px; height: 80px; background: #3b82f6; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 25px auto; box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3); }

    .restore-zone { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 40px; }
    .restore-alert { background: #fff7ed; border: 1px solid #ffedd5; color: #9a3412; padding: 20px; border-radius: 12px; margin-bottom: 30px; display: flex; gap: 15px; }
    .restore-alert i { font-size: 24px; color: #ea580c; }
</style>

<div class="backup-wrapper">
    <!-- Sidebar -->
    <div class="backup-sidebar">
        <ul class="nav-vault shadow-sm">
            <li class="active">
                <a href="#history" data-toggle="pill"><i class="fa fa-history"></i> Execution History</a>
            </li>
            <li>
                <a href="#new_backup" data-toggle="pill"><i class="fa fa-plus-circle"></i> Create Snapshot</a>
            </li>
            <li>
                <a href="#restore" data-toggle="pill"><i class="fa fa-refresh"></i> Data Restoration</a>
            </li>
        </ul>

        <div class="snapshot-status-card shadow-sm">
            <div class="snapshot-icon"><i class="fa fa-database"></i></div>
            <div class="snapshot-label">Latest Data Snapshot</div>
            <?php $last = !empty($backups) ? $backups[0] : null; if($last): ?>
                <div class="snapshot-date"><?php echo date('d M Y', strtotime($last['created_at'])); ?></div>
                <div class="text-primary font-bold small" style="margin-bottom: 5px;"><?php echo $last['filename']; ?></div>
                <div class="text-muted small"><?php echo $last['filesize']; ?> • SQL Storage</div>
            <?php else: ?>
                <div class="snapshot-date">NO BACKUPS</div>
                <div class="text-muted small">System is currently vulnerable.</div>
            <?php endif; ?>
        </div>

        <div class="alert alert-danger shadow-sm" style="margin-top: 25px; border-radius: 12px; background: #fef2f2; border: 1px solid #fee2e2; color: #b91c1c;">
            <p class="small no-margin"><i class="fa fa-shield"></i> <strong>Critical:</strong> Restoration is an irreversible operational state. All present data objects will be purged during the process.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="backup-main">
        <div class="tab-content no-padding">
            
            <!-- HISTORY TAB -->
            <div class="tab-pane active" id="history">
                <div class="history-card shadow-sm">
                    <div class="history-header">
                        <h4>Inventory of Snapshots</h4>
                        <div class="small text-muted">Total Records: <?php echo count($backups); ?></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-history">
                            <thead>
                                <tr>
                                    <th>Point in Time</th>
                                    <th>Identifier</th>
                                    <th>Volume</th>
                                    <th>Trigger</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($backups) && !empty($backups)): foreach ($backups as $b): ?>
                                <tr>
                                    <td>
                                        <div class="font-bold"><?php echo date('d M Y', strtotime($b['created_at'])); ?></div>
                                        <div class="small text-muted"><?php echo date('H:i:s', strtotime($b['created_at'])); ?></div>
                                    </td>
                                    <td><code style="background:transparent; color:#3b82f6;"><?php echo $b['filename']; ?></code></td>
                                    <td class="small font-bold"><?php echo $b['filesize']; ?></td>
                                    <td>
                                        <?php $isManual = $b['backup_type'] == 'manual'; ?>
                                        <span class="badge-backup <?php echo $isManual ? 'badge-manual' : 'badge-auto'; ?>">
                                            <i class="fa <?php echo $isManual ? 'fa-user' : 'fa-bolt'; ?>"></i> <?php echo $b['backup_type']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('admin/backups/download/'.$b['id']); ?>" class="btn btn-xs btn-default" title="Download Source"><i class="fa fa-download text-primary"></i></a>
                                            <button type="button" class="btn btn-xs btn-default btn-delete" data-id="<?php echo $b['id']; ?>" title="Purge Record"><i class="fa fa-trash text-danger"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center" style="padding: 100px 0;">
                                        <i class="fa fa-folder-open-o fa-3x text-gray-light"></i>
                                        <p class="text-muted mt-10">Historical vault is currently empty.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- NEW BACKUP TAB -->
            <div class="tab-pane" id="new_backup">
                <div class="history-card shadow-sm" style="padding: 40px;">
                    <div class="init-zone">
                        <div class="init-icon animated pulse infinite"><i class="fa fa-cloud-download"></i></div>
                        <h3 style="font-weight: 800; color: #1e293b;">Database Sovereignty Init</h3>
                        <p class="text-muted" style="max-width: 450px; margin: 0 auto 30px auto;">You are about to generate a complete schema and data blueprint of the system. This file will be securely stored in the infrastructure node.</p>
                        
                        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; display: inline-block; margin-bottom: 40px;">
                            <div class="small text-muted mb-5">TARGET STORAGE</div>
                            <div class="font-bold"><i class="fa fa-folder text-blue"></i> /uploads/backups/</div>
                        </div>

                        <div>
                            <button type="button" id="btn-create-backup" class="btn btn-primary btn-flat" style="padding: 15px 40px; font-weight: 800; font-size: 16px; border-radius: 12px; box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);">
                                <i class="fa fa-play-circle"></i> INITIALIZE BACKUP STREAM
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RESTORE TAB -->
            <div class="tab-pane" id="restore">
                <div class="restore-zone shadow-sm">
                    <h3 style="font-weight: 800; color: #1e293b; margin-top:0;"><i class="fa fa-refresh text-blue"></i> Entity Restoration</h3>
                    <p class="text-muted mb-30">Re-index and overwrite the logic foundation from an external source.</p>

                    <div class="restore-alert">
                        <i class="fa fa-exclamation-triangle"></i>
                        <div>
                            <div class="font-bold" style="font-size: 16px;">Irreversible State Warning</div>
                            <p class="small no-margin">Initializing a restoration stream will purge all present database objects. This action cannot be undone once the stream is committed.</p>
                        </div>
                    </div>

                    <form id="formRestore" enctype="multipart/form-data">
                        <div class="form-group mb-30">
                            <label class="text-muted small font-bold mb-10 d-block">SELECT BLUEPRINT SOURCE (SQL)</label>
                            <div class="input-group">
                                <span class="input-group-addon border-gray bg-gray-light"><i class="fa fa-file-code-o"></i></span>
                                <input type="file" name="backup_file" class="form-control btn-flat border-gray" accept=".sql" required style="height: 45px; padding-top: 10px;">
                            </div>
                            <p class="help-block small"><i class="fa fa-info-circle"></i> Standard SQL format only. Maximum upload capacity defined by infrastructure (Max: 50MB).</p>
                        </div>
                        
                        <button type="submit" class="btn btn-danger btn-flat" style="padding: 12px 35px; font-weight: 800; border-radius: 8px;">
                            <i class="fa fa-upload"></i> COMMENCE RESTORATION
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
$(function(){
    // --- 1. Tab Persistence ---
    function syncTab() {
        var hash = window.location.hash || '#history';
        $('.nav-vault li').removeClass('active');
        $('.nav-vault a[href="' + hash + '"]').parent().addClass('active');
        $('.tab-pane').removeClass('active');
        $(hash).addClass('active');
    }

    $('.nav-vault a').click(function(e) {
        e.preventDefault();
        var hash = $(this).attr('href');
        window.location.hash = hash;
        syncTab();
    });

    syncTab();

    // --- 2. Create Backup (AJAX) ---
    $('#btn-create-backup').click(function() {
        var btn = $(this);
        var original = btn.html();
        
        App.confirm('Execute Snapshot?', 'System will generate a master SQL blueprint of all data objects.', function() {
            btn.prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> GENERATING BLUEPRINT...');
            
            $.post(BASE_URL + 'admin/backups/backup', {}, function(res) {
                var r = JSON.parse(res);
                if(r.status == 'success') {
                    App.alert('Snapshot Created', r.message, 'success').then(() => {
                        window.location.hash = '#history';
                        location.reload();
                    });
                } else {
                    btn.prop('disabled', false).html(original);
                    App.alert('Generation Error', r.message, 'error');
                }
            });
        }, 'info');
    });

    // --- 3. Delete Backup ---
    $('.btn-delete').click(function() {
        var id = $(this).data('id');
        App.confirm('Purge Snapshot?', 'This will permanently remove the SQL blueprint from infrastructure storage.', function() {
            $.post(BASE_URL + 'admin/backups/delete/' + id, {}, function(res) {
                var r = JSON.parse(res);
                if(r.status == 'success') {
                    App.toast(r.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    App.alert('Deletion Error', r.message, 'error');
                }
            });
        }, 'danger');
    });

    // --- 4. Restoration Logic ---
    $('#formRestore').submit(function(e){
        e.preventDefault();
        App.confirm('Initialize Restoration System?', 'CRITICAL: This will destroy and overwrite existing data nodes.', function(){
            var formData = new FormData($('#formRestore')[0]);
            var btn = $('#formRestore button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> RESTORING DATA...');
            
            $.ajax({
                url: BASE_URL + 'admin/backups/restore',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res){
                    var r = JSON.parse(res);
                    if(r.status == 'success'){
                        App.alert('Restoration Complete', r.message, 'success').then(() => location.reload());
                    } else {
                        btn.prop('disabled', false).html('<i class="fa fa-upload"></i> COMMENCE RESTORATION');
                        App.alert('Stream Refused', r.message, 'error');
                    }
                }
            });
        }, 'danger');
    });
});
</script>

