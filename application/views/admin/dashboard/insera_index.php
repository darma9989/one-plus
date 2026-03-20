<!-- Custom Dark Mode Mac Tahoe Style -->
<style>
    :root {
        --mac-bg: #1c1c1e;
        --mac-card: #2c2c2e;
        --mac-border: #38383a;
        --mac-text: #ffffff;
        --mac-text-dim: #ebebf5;
        --mac-blue: #0a84ff;
        --mac-red: #ff453a;
        --mac-green: #32d74b;
    }

    .content-wrapper {
        background-color: var(--mac-bg) !important;
        color: var(--mac-text) !important;
    }

    .box {
        background: var(--mac-card) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
        color: var(--mac-text) !important;
        margin-bottom: 25px !important;
    }

    .box-header {
        border-bottom: 1px solid var(--mac-border) !important;
        padding: 15px !important;
    }

    .box-title {
        color: var(--mac-text) !important;
        font-weight: 700 !important;
    }

    .nav-tabs-custom {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    .nav-tabs-custom > .nav-tabs {
        border-bottom-color: var(--mac-border) !important;
        background: rgba(44, 44, 46, 0.5) !important;
        backdrop-filter: blur(10px);
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs-custom > .nav-tabs > li > a {
        color: var(--mac-text-dim) !important;
        font-weight: 600 !important;
        transition: 0.3s;
    }

    .nav-tabs-custom > .nav-tabs > li.active > a {
        background: var(--mac-card) !important;
        color: var(--mac-blue) !important;
        border: 0 !important;
        border-bottom: 3px solid var(--mac-blue) !important;
    }

    .nav-tabs-custom > .tab-content {
        background: transparent !important;
        padding: 20px 0 !important;
    }

    .pivot-table {
        background: var(--mac-card) !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        border: 1px solid var(--mac-border) !important;
    }

    .pivot-table thead, .pivot-table tfoot {
        background: #000000 !important;
        color: #ffffff !important;
    }

    .pivot-table thead th {
        border-color: var(--mac-border) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
    }

    .pivot-table tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    .pivot-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.07) !important;
    }

    .pivot-table td, .pivot-table th {
        border-color: var(--mac-border) !important;
        color: var(--mac-text) !important;
    }

    /* Background handled in the unified thead/tfoot rule above */

    /* Info Box Enhancements */
    .info-box {
        background: var(--mac-card) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        color: var(--mac-text) !important;
    }

    .info-box-icon {
        border-radius: 12px !important;
        background: rgba(255, 255, 255, 0.05) !important;
        color: #fff !important;
        box-shadow: inset 0 0 15px rgba(255,255,255,0.05);
    }

    .bg-aqua { color: var(--mac-blue) !important; background: transparent !important; }
    .bg-red { color: var(--mac-red) !important; background: transparent !important; }
    .bg-green { color: var(--mac-green) !important; background: transparent !important; }

    /* Modal Styling */
    .modal-content {
        background: var(--mac-bg) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 15px !important;
        color: var(--mac-text) !important;
    }

    .modal-header {
        border-bottom: 1px solid var(--mac-border) !important;
    }

    /* DataTables in Modal */
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter, 
    .dataTables_wrapper .dataTables_info, 
    .dataTables_wrapper .dataTables_processing, 
    .dataTables_wrapper .dataTables_paginate {
        color: var(--mac-text-dim) !important;
    }

    table.dataTable thead th {
        background: var(--mac-card) !important;
        color: var(--mac-text) !important;
        border-bottom: 1px solid var(--mac-border) !important;
    }

    .btn-danger { background-color: var(--mac-red) !important; border-color: var(--mac-red) !important; color: #fff !important; }
    .btn-success { background-color: var(--mac-green) !important; border-color: var(--mac-green) !important; color: #fff !important; }
    .btn-primary { background-color: var(--mac-blue) !important; border-color: var(--mac-blue) !important; color: #fff !important; }

    /* Unified Dark Mode Badges/Labels */
    .label {
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 4px 10px !important;
        border-radius: 50px !important;
    }

    .label-danger { 
        background: rgba(255, 69, 58, 0.15) !important; 
        color: var(--mac-red) !important; 
        border: 1px solid rgba(255, 69, 58, 0.3) !important;
    }

    .label-success { 
        background: rgba(50, 215, 75, 0.15) !important; 
        color: var(--mac-green) !important; 
        border: 1px solid rgba(50, 215, 75, 0.3) !important;
    }

    .label-info { 
        background: rgba(10, 132, 255, 0.15) !important; 
        color: var(--mac-blue) !important; 
        border: 1px solid rgba(10, 132, 255, 0.3) !important;
    }

    /* Override text-muted for dark mode visibility */
    .text-muted {
        color: var(--mac-text-dim) !important;
    }

    /* Advanced Modal Styling - Black Theme */
    .modal-body {
        background: #000000 !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
        padding: 5px 10px !important;
        margin-left: 10px !important;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li > a {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        transition: 0.3s;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li > a:hover {
        background: var(--mac-card) !important;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li.active > a {
        background: #444446 !important;
        border-color: #444446 !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--mac-text-dim) !important;
    }

    #detailTable {
        border-color: var(--mac-border) !important;
    }

    #detailTable th, #detailTable td {
        border-color: var(--mac-border) !important;
    }

    #detailTable tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    #detailTable tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.07) !important;
    }
    #detailTable thead, #detailTable thead th {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: var(--mac-border) !important;
        vertical-align: middle !important;
        text-align: center !important;
    }

    .dataTables_wrapper .dataTables_length select {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 5px !important;
        padding: 2px 5px !important;
    }

    .dataTables_wrapper .dataTables_length {
        color: var(--mac-text-dim) !important;
    }

    /* Global Style for Export Buttons (Excel, PDF, Print) */
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
</style>

<?php 
    $workzone_group = $this->session->userdata('workzone');
    if (!$this->session->userdata('is_superadmin') && $workzone_group): 
        $mapping = array(
            '1' => 'TRK, TAJ, JWT',
            '2' => 'MLN, TPE, NNK, SNY',
            '3' => 'TRD, TBY, LNN, TSL, TLA',
            '4' => 'MLN, TPE',
            '5' => 'NNK, SNY',
            '6' => 'TSL, TLA',
            '7' => 'TRD, TBY, LNN'
        );
        $codes = isset($mapping[$workzone_group]) ? $mapping[$workzone_group] : 'Unknown';
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert" style="background: rgba(10, 132, 255, 0.1); border: 1px solid rgba(10, 132, 255, 0.2); border-radius: 10px; margin-bottom: 20px;">
            <i class="fa fa-filter" style="color: var(--mac-blue); margin-right: 10px;"></i>
            <span style="color: #fff; font-weight: 500;">Menampilkan data Ter-Filter untuk Workzone: </span>
            <span class="label label-info" style="margin-left: 5px; font-weight: 700;"><?php echo $codes; ?></span>
            <small class="pull-right text-muted" style="margin-top: 3px;">Bersumber dari Group <?php echo $workzone_group; ?></small>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box border-0 shadow-sm" style="border-radius: 8px;">
            <span class="info-box-icon bg-aqua" style="border-radius: 8px 0 0 8px;"><i class="fa fa-ticket"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase text-muted" style="font-weight: 700;">Total Tickets</span>
                <span class="info-box-number" style="font-size: 28px;"><?php echo number_format($stats['total']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box border-0 shadow-sm" style="border-radius: 8px;">
            <span class="info-box-icon bg-red" style="border-radius: 8px 0 0 8px;"><i class="fa fa-folder-open"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase text-muted" style="font-weight: 700;">Open Tickets</span>
                <span class="info-box-number" style="font-size: 28px;"><?php echo number_format($stats['open']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box border-0 shadow-sm" style="border-radius: 8px;">
            <span class="info-box-icon bg-green" style="border-radius: 8px 0 0 8px;"><i class="fa fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase text-muted" style="font-weight: 700;">Closed Tickets</span>
                <span class="info-box-number" style="font-size: 28px;"><?php echo number_format($stats['closed']); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="nav-tabs-custom" style="margin-top: 20px;">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_open" data-toggle="tab" style="font-weight: 700; color: #dd4b39;"><i class="fa fa-folder-open"></i> Distribusi Tiket OPEN</a></li>
        <li><a href="#tab_closed" data-toggle="tab" style="font-weight: 700; color: #00a65a;"><i class="fa fa-check-circle"></i> Distribusi Tiket CLOSED</a></li>
        <li class="pull-right" style="padding: 10px 15px;">
            <div style="background: rgba(255,255,255,0.05); border: 1px solid var(--mac-border); border-radius: 50px; padding: 4px 15px; font-size: 11px; color: var(--mac-text-dim);">
                <i class="fa fa-clock-o" style="color: var(--mac-blue); margin-right: 5px;"></i>
                Last Update: <span style="color: #fff; font-weight: 700;"><?php echo $last_update ? date('d M Y, H:i', strtotime($last_update)) : '—'; ?></span>
                <span style="margin: 0 8px; opacity: 0.3;">|</span>
                <i class="fa fa-refresh" style="color: var(--mac-green); margin-right: 5px;"></i>
                <span id="refreshCountdown" style="color: var(--mac-text-dim); font-weight: 500;">20:00</span>
            </div>
        </li>
    </ul>
    <div class="tab-content">
        <!-- TAB OPEN -->
        <div class="tab-pane active" id="tab_open">
            <?php if(empty($pivot_open)): ?>
                <div class="alert alert-info">Belum ada data tiket OPEN.</div>
            <?php else: ?>
                <?php foreach ($pivot_open as $category => $rows): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="font-weight: 600;">Scrape Kategori: <span class="label label-danger"><?php echo htmlspecialchars($category); ?></span></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped table-hover pivot-table">
                            <thead>
                                <tr style="background: #000000 !important; color: #ffffff !important;">
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Service Area</th>
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Sektor</th>
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Workzone</th>
                                    <th class="text-center" colspan="8" style="letter-spacing: 1px; text-align: center; background: #000000 !important; color: #ffffff !important;">DURASI TIKET OPEN</th>
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Total</th>
                                </tr>
                                <tr style="background: #000000 !important; color: #ffffff !important;">
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">&lt; 1 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">1-2 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">2-3 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">3-6 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">6-12 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">12-36 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">36-72 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">&gt; 72 jam</th>
                                </tr>
                            </thead>
                                <?php 
                                $gt_buckets = array('< 1 jam'=>0, '1-2 jam'=>0, '2-3 jam'=>0, '3-6 jam'=>0, '6-12 jam'=>0, '12-36 jam'=>0, '36-72 jam'=>0, '> 72 jam'=>0);
                                $gt_total = 0;

                                // Pre-calculate rowspans
                                $sa_spans = [];
                                $sektor_spans = [];
                                foreach($rows as $rv) {
                                    $sa_key = $rv['service_area'];
                                    $sk_key = $rv['service_area'] . '|' . $rv['sektor'];
                                    $sa_spans[$sa_key] = (isset($sa_spans[$sa_key]) ? $sa_spans[$sa_key] : 0) + 1;
                                    $sektor_spans[$sk_key] = (isset($sektor_spans[$sk_key]) ? $sektor_spans[$sk_key] : 0) + 1;
                                }
                                $sa_done = [];
                                $sk_done = [];

                                foreach($rows as $r): 
                                    $current_sa = $r['service_area'];
                                    $current_sk = $r['service_area'] . '|' . $r['sektor'];
                                ?>
                                <tr>
                                    <?php if(!isset($sa_done[$current_sa])): ?>
                                        <td class="text-center" rowspan="<?php echo $sa_spans[$current_sa]; ?>" style="font-weight: 700; text-align: center; vertical-align: middle; background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--mac-border);"><?php echo htmlspecialchars($current_sa); ?></td>
                                        <?php $sa_done[$current_sa] = true; ?>
                                    <?php endif; ?>

                                    <?php if(!isset($sk_done[$current_sk])): ?>
                                        <td class="text-center" rowspan="<?php echo $sektor_spans[$current_sk]; ?>" style="font-weight: 600; text-align: center; vertical-align: middle; background: rgba(255,255,255,0.01); border-bottom: 1px solid var(--mac-border);"><?php echo htmlspecialchars($r['sektor']); ?></td>
                                        <?php $sk_done[$current_sk] = true; ?>
                                    <?php endif; ?>

                                    <td class="text-center" style="font-weight: 600; text-align: center; vertical-align: middle;"><?php echo htmlspecialchars($r['work_zone']); ?></td>
                                    <?php 
                                    $row_total = 0;
                                    $buckets = ['< 1 jam', '1-2 jam', '2-3 jam', '3-6 jam', '6-12 jam', '12-36 jam', '36-72 jam', '> 72 jam'];
                                    foreach($buckets as $b):
                                        $val = isset($r[$b]) ? (int)$r[$b] : 0;
                                        if ($val > 0) {
                                            echo '<td class="text-center" style="text-align: center; vertical-align: middle;"><a href="javascript:void(0)" class="btn btn-xs" style="width: 100%; border-radius: 20px; font-weight: bold; background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.1);" onclick="showDetail(\''.htmlspecialchars($category).'\', \''.htmlspecialchars($r['work_zone']).'\', \'OPEN\', \''.htmlspecialchars($b).'\')">'.$val.'</a></td>';
                                        } else {
                                            echo '<td class="text-center text-muted" style="text-align: center; vertical-align: middle;">0</td>';
                                        }
                                        $row_total += $val;
                                        $gt_buckets[$b] += $val;
                                    endforeach;
                                    $gt_total += $row_total;
                                    ?>
                                    <td class="text-center" style="font-weight: 800; font-size: 16px; text-align: center; vertical-align: middle;">
                                        <?php if($row_total > 0): ?>
                                            <a href="javascript:void(0)" class="text-white" style="font-weight: 800; text-decoration: underline; color: #fff !important;" onclick="showDetail('<?php echo htmlspecialchars($category); ?>', '<?php echo htmlspecialchars($r['work_zone']); ?>', 'OPEN', 'ALL')"><?php echo $row_total; ?></a>
                                        <?php else: echo 0; endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot style="background: #000000 !important; color: #ffffff !important;">
                                <tr style="background: #000000 !important; color: #ffffff !important;">
                                    <td class="text-center" colspan="3" style="vertical-align: middle; font-size: 14px; text-align: center; color: #fff; background: #000000 !important;">GRAND TOTAL</td>
                                    <?php foreach($gt_buckets as $bk => $val): ?>
                                        <td class="text-center" style="vertical-align: middle; text-align: center; background: #000000 !important;">
                                            <?php if($val > 0): ?>
                                                <a href="javascript:void(0)" class="text-white" style="font-weight: 800; text-decoration: underline; color: #fff !important;" onclick="showDetail('<?php echo htmlspecialchars($category); ?>', 'ALL', 'OPEN', '<?php echo htmlspecialchars($bk); ?>')"><?php echo number_format($val); ?></a>
                                            <?php else: echo 0; endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="text-center" style="vertical-align: middle; font-size: 16px; color: #fff; text-align: center; background: #000000 !important;">
                                        <?php if($gt_total > 0): ?>
                                            <a href="javascript:void(0)" class="text-white" style="font-weight: 800; text-decoration: underline; color: #fff !important;" onclick="showDetail('<?php echo htmlspecialchars($category); ?>', 'ALL', 'OPEN', 'ALL')"><?php echo number_format($gt_total); ?></a>
                                        <?php else: echo 0; endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- TAB CLOSED -->
        <div class="tab-pane" id="tab_closed">
            <?php if(empty($pivot_closed)): ?>
                <div class="alert alert-info">Belum ada data tiket CLOSED.</div>
            <?php else: ?>
                <?php foreach ($pivot_closed as $category => $rows): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="font-weight: 600;">Scrape Kategori: <span class="label label-success"><?php echo htmlspecialchars($category); ?></span></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped table-hover pivot-table">
                            <thead>
                                <tr style="background: #000000 !important; color: #ffffff !important;">
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Service Area</th>
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Sektor</th>
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Workzone</th>
                                    <th class="text-center" colspan="8" style="letter-spacing: 1px; text-align: center; background: #000000 !important; color: #ffffff !important;">DURASI TIKET CLOSED</th>
                                    <th class="text-center align-middle" rowspan="2" style="vertical-align: middle; text-align: center; background: #000000 !important; color: #ffffff !important;">Total</th>
                                </tr>
                                <tr style="background: #000000 !important; color: #ffffff !important;">
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">&lt; 1 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">1-2 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">2-3 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">3-6 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">6-12 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">12-36 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">36-72 jam</th>
                                    <th class="text-center" style="text-align: center; background: #000000 !important; color: #ffffff !important;">&gt; 72 jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $gt_buckets = array('< 1 jam'=>0, '1-2 jam'=>0, '2-3 jam'=>0, '3-6 jam'=>0, '6-12 jam'=>0, '12-36 jam'=>0, '36-72 jam'=>0, '> 72 jam'=>0);
                                $gt_total = 0;

                                // Pre-calculate rowspans
                                $sa_spans = [];
                                $sektor_spans = [];
                                foreach($rows as $rv) {
                                    $sa_key = $rv['service_area'];
                                    $sk_key = $rv['service_area'] . '|' . $rv['sektor'];
                                    $sa_spans[$sa_key] = (isset($sa_spans[$sa_key]) ? $sa_spans[$sa_key] : 0) + 1;
                                    $sektor_spans[$sk_key] = (isset($sektor_spans[$sk_key]) ? $sektor_spans[$sk_key] : 0) + 1;
                                }
                                $sa_done = [];
                                $sk_done = [];

                                foreach($rows as $r): 
                                    $current_sa = $r['service_area'];
                                    $current_sk = $r['service_area'] . '|' . $r['sektor'];
                                ?>
                                <tr>
                                    <?php if(!isset($sa_done[$current_sa])): ?>
                                        <td class="text-center" rowspan="<?php echo $sa_spans[$current_sa]; ?>" style="font-weight: 700; text-align: center; vertical-align: middle; background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--mac-border);"><?php echo htmlspecialchars($current_sa); ?></td>
                                        <?php $sa_done[$current_sa] = true; ?>
                                    <?php endif; ?>

                                    <?php if(!isset($sk_done[$current_sk])): ?>
                                        <td class="text-center" rowspan="<?php echo $sektor_spans[$current_sk]; ?>" style="font-weight: 600; text-align: center; vertical-align: middle; background: rgba(255,255,255,0.01); border-bottom: 1px solid var(--mac-border);"><?php echo htmlspecialchars($r['sektor']); ?></td>
                                        <?php $sk_done[$current_sk] = true; ?>
                                    <?php endif; ?>

                                    <td class="text-center" style="font-weight: 600; text-align: center; vertical-align: middle;"><?php echo htmlspecialchars($r['work_zone']); ?></td>
                                    <?php 
                                    $row_total = 0;
                                    $buckets = ['< 1 jam', '1-2 jam', '2-3 jam', '3-6 jam', '6-12 jam', '12-36 jam', '36-72 jam', '> 72 jam'];
                                    foreach($buckets as $b):
                                        $val = isset($r[$b]) ? (int)$r[$b] : 0;
                                        if ($val > 0) {
                                            echo '<td class="text-center" style="text-align: center; vertical-align: middle;"><a href="javascript:void(0)" class="btn btn-xs" style="width: 100%; border-radius: 20px; font-weight: bold; background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.1);" onclick="showDetail(\''.htmlspecialchars($category).'\', \''.htmlspecialchars($r['work_zone']).'\', \'CLOSED\', \''.htmlspecialchars($b).'\')">'.$val.'</a></td>';
                                        } else {
                                            echo '<td class="text-center text-muted" style="text-align: center; vertical-align: middle;">0</td>';
                                        }
                                        $row_total += $val;
                                        $gt_buckets[$b] += $val;
                                    endforeach;
                                    $gt_total += $row_total;
                                    ?>
                                    <td class="text-center" style="font-weight: 800; font-size: 16px; text-align: center; vertical-align: middle;">
                                        <?php if($row_total > 0): ?>
                                            <a href="javascript:void(0)" class="text-white" style="font-weight: 800; text-decoration: underline; color: #fff !important;" onclick="showDetail('<?php echo htmlspecialchars($category); ?>', '<?php echo htmlspecialchars($r['work_zone']); ?>', 'CLOSED', 'ALL')"><?php echo $row_total; ?></a>
                                        <?php else: echo 0; endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot style="background: #000000 !important; color: #ffffff !important;">
                                <tr style="background: #000000 !important; color: #ffffff !important;">
                                    <td class="text-center" colspan="3" style="vertical-align: middle; font-size: 14px; text-align: center; color: #fff; background: #000000 !important;">GRAND TOTAL</td>
                                    <?php foreach($gt_buckets as $bk => $val): ?>
                                        <td class="text-center" style="vertical-align: middle; text-align: center; background: #000000 !important;">
                                            <?php if($val > 0): ?>
                                                <a href="javascript:void(0)" class="text-white" style="font-weight: 800; color: #fff !important;" onclick="showDetail('<?php echo htmlspecialchars($category); ?>', 'ALL', 'CLOSED', '<?php echo htmlspecialchars($bk); ?>')"><?php echo number_format($val); ?></a>
                                            <?php else: echo 0; endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="text-center" style="vertical-align: middle; font-size: 16px; color: #fff; text-align: center; background: #000000 !important;">
                                        <?php if($gt_total > 0): ?>
                                            <a href="javascript:void(0)" class="text-white" style="font-weight: 800; text-decoration: underline; color: #fff !important;" onclick="showDetail('<?php echo htmlspecialchars($category); ?>', 'ALL', 'CLOSED', 'ALL')"><?php echo number_format($gt_total); ?></a>
                                        <?php else: echo 0; endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal pop-up for ticket details -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1200px;" role="document">
    <div class="modal-content border-0" style="border-radius: 10px; overflow: hidden;">
      <div class="modal-header shadow-sm" style="border:0; background: #000000 !important; color: #ffffff !important;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity: 1;"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalTitle" style="color:#fff; font-weight: 700;">
            <i class="fa fa-list"></i> Daftar Tiket Detail
        </h4>
      </div>
      <div class="modal-body" style="padding: 20px;">
        <div class="box" style="margin-bottom: 0;">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped table-hover" id="detailTable" width="100%">
                    <thead style="background: #000000 !important; color: #ffffff !important;">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Ticket ID</th>
                            <th>Service No</th>
                            <th>Workzone</th>
                            <th>Customer Type</th>
                            <th>Reported Date</th>
                            <th>Ticket Status</th>
                            <th>TTR Customer</th>
                            <th>Summary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Injected by AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer border-0" style="background: #000000 !important;">
        <button type="button" class="btn btn-flat" style="border-radius: 8px; background: #000000; color: #fff; border: 1px solid var(--mac-border); padding: 8px 25px; transition: 0.3s;" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
var dtDetail;
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

$(document).ready(function() {
    // $('.pivot-table').DataTable({
    //     "paging": false,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": false,
    //     "autoWidth": false
    // });
    
    dtDetail = $('#detailTable').DataTable({
        "autoWidth": false,
        "searching": true,
        "language": {
            "search": "Cari Cepat:",
            "lengthMenu": "Tampilkan _MENU_ baris",
            "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ tiket"
        }
    });
});

function formatSeconds(seconds) {
    if (!seconds || isNaN(seconds)) return '00:00';
    var hrs = Math.floor(seconds / 3600);
    var mins = Math.floor((seconds % 3600) / 60);
    return (hrs < 10 ? "0" + hrs : hrs) + ":" + (mins < 10 ? "0" + mins : mins);
}

function showDetail(category, workzone, statusType, bucket) {
    $('#modalTitle').html('<i class="fa fa-list"></i> Rincian <strong>' + category + ' (' + statusType + ')</strong> &nbsp;&nbsp;|&nbsp;&nbsp; ' + workzone + ' &nbsp;&nbsp;|&nbsp;&nbsp; Durasi: <strong>' + bucket + '</strong>');
    
    var reqData = {
        scrape_category: category,
        work_zone: workzone,
        status_type: statusType,
        bucket: bucket
    };
    reqData[csrfName] = csrfHash; // Inject CSRF token
    
    // Call AJAX
    $.ajax({
        url: '<?php echo base_url('admin/dashboard_insera/ajax_get_detail_tickets'); ?>',
        type: 'POST',
        dataType: 'json',
        data: reqData,
        beforeSend: function() {
            // Optional visual feedback
            dtDetail.clear().draw();
            $('#modalDetail').modal('show');
        },
        success: function(response) {
            // Update hash token if regenerated
            if(response.csrf_token) {
                csrfHash = response.csrf_token;
            }
            
            var rows = [];
            if(response.data && response.data.length > 0) {
                $.each(response.data, function(i, item) {
                    rows.push([
                        (i+1),
                        '<strong>' + (item.ticket_id || '-') + '</strong>',
                        '<strong>' + (item.service_no || '-') + '</strong>',
                        item.work_zone,
                        '<code>' + (item.customer_type || '-') + '</code>',
                        item.reported_date,
                        '<span class="label label-' + (statusType == 'OPEN' ? 'danger' : 'success') + '">' + item.ticket_status + '</span>',
                        '<strong class="text-primary">' + formatSeconds(item.ttr_customer) + '</strong>',
                        '<div style="max-height: 80px; overflow-y: auto; font-size: 11px; line-height: 1.4; color: #ccc; min-width: 250px; white-space: normal; word-break: break-all;">' + (item.summary || '-') + '</div>'
                    ]);
                });
            }
            dtDetail.rows.add(rows).draw();
        },
        error: function(err) {
            alert('Gagal mengeksekusi request ke server. Pastikan session Anda belum login ulang.');
        }
    });
}

// Auto Refresh Logic (20 Minutes)
var refreshTime = 20 * 60; // 20 minutes in seconds
var countdown = refreshTime;

function updateCountdown() {
    var mins = Math.floor(countdown / 60);
    var secs = countdown % 60;
    $('#refreshCountdown').text('Refresh in: ' + (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs);
    
    if (countdown <= 0) {
        // Check if any modal is open before refreshing
        if ($('.modal.in').length === 0 && $('.modal.show').length === 0) {
            location.reload();
        } else {
            // If modal is open, wait another minute
            countdown = 60; 
        }
    } else {
        countdown--;
    }
}

// Start countdown
setInterval(updateCountdown, 1000);
</script>
