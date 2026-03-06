<style>
    /* Minimalist Professional Styling */
    .dashboard-container { padding: 5px; }
    
    .page-title-box { margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; }
    .page-title-box h4 { margin: 0; font-weight: 700; color: #334155; font-size: 20px; }

    /* Clean Metric Cards */
    .stat-card { 
        background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 20px; 
        display: flex; align-items: center; gap: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .stat-icon { 
        width: 45px; height: 45px; border-radius: 6px; display: flex; align-items: center; 
        justify-content: center; font-size: 18px;
    }
    .stat-info { flex-grow: 1; }
    .stat-info .label-text { color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
    .stat-info .value-text { font-size: 24px; font-weight: 700; color: #1e293b; display: block; line-height: 1; }

    .bg-indigo-light { background: #eef2ff; color: #4f46e5; }
    .bg-emerald-light { background: #ecfdf5; color: #10b981; }
    .bg-amber-light { background: #fffbeb; color: #f59e0b; }

    /* Refined Content Area */
    .content-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 25px; overflow: hidden; }
    .content-box-header { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; background: #fff; }
    .content-box-header h5 { margin: 0; font-weight: 700; color: #334155; font-size: 15px; }
    
    .table-minimal thead th { background: #f8fafc; color: #64748b; font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
    .table-minimal td { padding: 12px 15px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 13px; }
    .table-minimal tr:last-child td { border-bottom: none; }

    .badge-status { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; display: inline-block; }
    .status-create { background: #dcfce7; color: #166534; }
    .status-update { background: #dbeafe; color: #1e40af; }
    .status-delete { background: #fee2e2; color: #991b1b; }
    .status-default { background: #f1f5f9; color: #475569; }

    /* Sidebar Widgets */
    .widget-panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px; }
    .widget-heading { font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; }
    
    .check-list { list-style: none; padding: 0; margin: 0; }
    .check-list li { display: flex; justify-content: space-between; padding: 10px 0; font-size: 13px; border-bottom: 1px solid #f8fafc; }
    .check-list li:last-child { border-bottom: none; }
    .check-list .key { color: #64748b; }
    .check-list .val { font-weight: 600; color: #1e293b; }

    .nav-btn { 
        display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 6px; 
        color: #475569; text-decoration: none !important; transition: all 0.2s; font-size: 13px; font-weight: 500;
    }
    .nav-btn:hover { background: #f8fafc; color: #2563eb; padding-left: 15px; }
    .nav-btn i { font-size: 14px; width: 18px; text-align: center; color: #94a3b8; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-container">
    <div class="page-title-box">
        <h4>Dashboard Overview</h4>
        <div class="text-muted small">Logged in as <strong><?php echo $this->session->userdata('nama'); ?></strong> • <?php echo date('l, d M Y'); ?></div>
    </div>

    <!-- Dynamic Widgets Area -->
    <div class="row">
        <!-- FIRST PASS: STAT BOXES -->
        <?php foreach ($widgets as $w): if ($w['type'] == 'stat_box'): ?>
        <div class="col-md-<?php echo $w['grid_size']; ?>" style="margin-bottom: 20px;">
            <div class="stat-card">
                <div class="stat-icon <?php echo strpos($w['color'], '-') !== false ? 'bg-'.$w['color'] : ''; ?>" style="<?php echo strpos($w['color'], '-') === false ? 'background:'.$w['color'].'; color:#fff;' : ''; ?>">
                    <i class="fa <?php echo $w['icon']; ?>"></i>
                </div>
                <div class="stat-info">
                    <span class="label-text"><?php echo $w['title']; ?></span>
                    <span class="value-text"><?php echo is_numeric($w['value']) ? number_format($w['value']) : $w['value']; ?></span>
                </div>
            </div>
        </div>
        <?php endif; endforeach; ?>
    </div>

    <div class="row">
        <!-- SECOND PASS: CHARTS & LISTS -->
        <div class="col-md-8">
            <div class="row">
                <?php foreach ($widgets as $w): if ($w['type'] != 'stat_box' && $w['grid_size'] >= 8): ?>
                    <div class="col-md-12">
                        <div class="content-box">
                            <div class="content-box-header">
                                <h5><i class="fa <?php echo $w['icon']; ?> text-muted"></i> <?php echo $w['title']; ?></h5>
                            </div>
                            <div style="padding: 20px;">
                                <?php if ($w['type'] == 'line_chart'): ?>
                                    <canvas id="chart-<?php echo $w['id']; ?>" style="height: 250px;"></canvas>
                                <?php elseif ($w['type'] == 'pie_chart'): ?>
                                    <canvas id="chart-<?php echo $w['id']; ?>" style="height: 250px;"></canvas>
                                <?php elseif ($w['type'] == 'recent_list'): ?>
                                     <ul class="check-list">
                                        <?php foreach ($w['list_data'] as $item): ?>
                                        <li>
                                            <span class="key"><?php echo $item['_main']; ?></span>
                                            <span class="val small text-muted"><?php echo date('d M Y', strtotime($item['created_at'])); ?></span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php elseif ($w['type'] == 'pivot_table'): ?>
                                    <table class="table table-condensed table-striped table-minimal no-margin">
                                        <thead>
                                            <tr>
                                                <th><?php echo strtoupper($w['calc_field']); ?></th>
                                                <th class="text-right">TOTAL (<?php echo $w['calc_type']; ?>)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($w['pivot_data'] as $p): ?>
                                            <tr>
                                                <td><strong><?php echo $p['dimension'] ?: 'N/A'; ?></strong></td>
                                                <td class="text-right"><?php echo number_format($p['total']); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; endforeach; ?>
            </div>

            <!-- Default Activity Log if no big widgets -->
            <div class="content-box">
                <div class="content-box-header">
                    <h5>Recent System Activities (Global Audit)</h5>
                    <a href="<?php echo base_url('admin/activity_log'); ?>" class="btn btn-default btn-xs" style="border-radius:4px; font-weight:600;">View Full Audit</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-minimal no-margin">
                        <thead>
                            <tr>
                                <th width="100">Time</th>
                                <th width="110">Action</th>
                                <th>Module / Item</th>
                                <th>User Actor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_logs)): foreach ($recent_logs as $log): ?>
                                <tr>
                                    <td class="text-muted"><?php echo date('H:i', strtotime($log['created_at'])); ?> <small><?php echo date('d M', strtotime($log['created_at'])); ?></small></td>
                                    <td>
                                        <?php 
                                            $s_class = 'status-default';
                                            if ($log['action'] == 'CREATE') $s_class = 'status-create';
                                            elseif ($log['action'] == 'UPDATE') $s_class = 'status-update';
                                            elseif ($log['action'] == 'DELETE') $s_class = 'status-delete';
                                            elseif ($log['action'] == 'BATCH_INSERT') $s_class = 'status-create';
                                        ?>
                                        <span class="badge-status <?php echo $s_class; ?>"><?php echo $log['action']; ?></span>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size: 11px;"><?php echo $log['module']; ?></span><br>
                                        <strong style="color: #334155;"><?php echo $log['item_name'] ?: '-'; ?></strong>
                                    </td>
                                    <td>
                                        <strong><?php echo $log['user_name'] ?: 'System'; ?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="4" class="text-center" style="padding: 60px; color: #94a3b8;">No recent activity logs detected.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-md-4">
            <!-- System Health -->
            <div class="widget-panel">
                <div class="widget-heading"><i class="fa fa-heartbeat text-red"></i> System Diagnostics</div>
                <ul class="check-list">
                    <li>
                        <span class="key">Memory Usage</span>
                        <span class="val"><?php echo $sys_health['memory_usage']; ?></span>
                    </li>
                    <li>
                        <span class="key">PHP Version</span>
                        <span class="val"><?php echo $sys_health['php_version']; ?></span>
                    </li>
                    <li>
                        <span class="key">MySQL Engine</span>
                        <span class="val">v<?php echo $sys_health['mysql_version']; ?></span>
                    </li>
                    <li>
                        <span class="key">Upload Path</span>
                        <span class="val <?php echo $sys_health['is_writeable'] ? 'text-green' : 'text-red'; ?>">
                            <?php echo $sys_health['is_writeable'] ? 'Writable' : 'Error'; ?>
                        </span>
                    </li>
                </ul>
            </div>

            <!-- Operations -->
            <div class="widget-panel">
                <div class="widget-heading"><i class="fa fa-bolt text-warning"></i> Quick Navigation</div>
                <div class="nav-list">
                    <a href="<?php echo base_url('admin/users'); ?>" class="nav-btn">
                        <i class="fa fa-user-plus"></i> User Management
                    </a>
                    <a href="<?php echo base_url('admin/menus'); ?>" class="nav-btn">
                        <i class="fa fa-list"></i> Menu Management
                    </a>
                    <a href="<?php echo base_url('admin/settings'); ?>" class="nav-btn">
                        <i class="fa fa-sliders"></i> System Settings
                    </a>
                    <a href="<?php echo base_url('admin/backups'); ?>" class="nav-btn">
                        <i class="fa fa-database"></i> Database Backups
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    <?php foreach ($widgets as $w): if ($w['type'] == 'line_chart' || $w['type'] == 'pie_chart'): ?>
        var ctx_<?php echo $w['id']; ?> = document.getElementById('chart-<?php echo $w['id']; ?>').getContext('2d');
        var labels_<?php echo $w['id']; ?> = <?php echo json_encode(array_column($w['chart_data'], 'label')); ?>;
        var values_<?php echo $w['id']; ?> = <?php echo json_encode(array_column($w['chart_data'], 'value')); ?>;
        
        <?php if ($w['type'] == 'line_chart'): ?>
        new Chart(ctx_<?php echo $w['id']; ?>, {
            type: 'line',
            data: {
                labels: labels_<?php echo $w['id']; ?>,
                datasets: [{
                    label: '<?php echo $w['title']; ?>',
                    data: values_<?php echo $w['id']; ?>,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
        <?php else: ?>
        new Chart(ctx_<?php echo $w['id']; ?>, {
            type: 'doughnut',
            data: {
                labels: labels_<?php echo $w['id']; ?>,
                datasets: [{
                    data: values_<?php echo $w['id']; ?>,
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
        <?php endif; ?>
    <?php endif; endforeach; ?>
});
</script>
