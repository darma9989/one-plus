<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom" style="border-radius:12px; overflow:hidden; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_witel" data-toggle="tab">1. WITEL</a></li>
                <li><a href="#tab_sa" data-toggle="tab">2. SERVICE AREA</a></li>
                <li><a href="#tab_sk" data-toggle="tab">3. SEKTOR</a></li>
                <li><a href="#tab_sto" data-toggle="tab">4. STO</a></li>
                <li><a href="#tab_ws" data-toggle="tab">5. WILSUS</a></li>
                <li><a href="#tab_struct" data-toggle="tab" class="text-bold text-primary"><i class="fa fa-sitemap"></i> 6. STRUKTUR</a></li>
            </ul>
            <div class="tab-content" style="padding:20px;">
                
                <!-- 1. WITEL -->
                <div class="tab-pane active" id="tab_witel">
                    <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="font-weight:700; margin:0;"><i class="fa fa-map text-primary"></i> Master Witel</h4>
                        <button class="btn btn-primary btn-flat" onclick="addWitel()"><i class="fa fa-plus"></i> Tambah Witel</button>
                    </div>
                    <table id="tblWitel" class="table table-hover" style="width:100%;">
                        <thead><tr><th>NO</th><th>NAMA WITEL</th><th style="width:80px;">AKSI</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- 2. SERVICE AREA -->
                <div class="tab-pane" id="tab_sa">
                    <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="font-weight:700; margin:0;"><i class="fa fa-map-signs text-success"></i> Master Service Area</h4>
                        <button class="btn btn-success btn-flat" onclick="addSA()"><i class="fa fa-plus"></i> Tambah Service Area</button>
                    </div>
                    <table id="tblSA" class="table table-hover" style="width:100%;">
                        <thead><tr><th>NO</th><th>NAMA SERVICE AREA</th><th>WITEL</th><th style="width:80px;">AKSI</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- 3. SEKTOR -->
                <div class="tab-pane" id="tab_sk">
                    <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="font-weight:700; margin:0;"><i class="fa fa-compass text-warning"></i> Master Sektor</h4>
                        <button class="btn btn-warning btn-flat" onclick="addSK()" style="color:#fff;"><i class="fa fa-plus"></i> Tambah Sektor</button>
                    </div>
                    <table id="tblSK" class="table table-hover" style="width:100%;">
                        <thead><tr><th>NO</th><th>NAMA SEKTOR</th><th>SERVICE AREA</th><th style="width:80px;">AKSI</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- 4. STO -->
                <div class="tab-pane" id="tab_sto">
                    <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="font-weight:700; margin:0;"><i class="fa fa-building text-info"></i> Master STO</h4>
                        <button class="btn btn-info btn-flat" onclick="addSTO()"><i class="fa fa-plus"></i> Tambah STO</button>
                    </div>
                    <table id="tblSTO" class="table table-hover" style="width:100%;">
                        <thead><tr><th>NO</th><th>KODE</th><th>NAMA STO</th><th>SEKTOR</th><th style="width:80px;">AKSI</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- 5. WILSUS -->
                <div class="tab-pane" id="tab_ws">
                    <div style="margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="font-weight:700; margin:0;"><i class="fa fa-map-pin text-danger"></i> Master Wilsus</h4>
                        <button class="btn btn-danger btn-flat" onclick="addWS()"><i class="fa fa-plus"></i> Tambah Wilsus</button>
                    </div>
                    <table id="tblWS" class="table table-hover" style="width:100%;">
                        <thead><tr><th>NO</th><th>NAMA WILSUS</th><th>STO</th><th style="width:80px;">AKSI</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- 6. STRUKTUR (TREE VIEW) -->
                <div class="tab-pane" id="tab_struct">
                    <div class="hierarchy-tree">
                        <ul>
                            <?php foreach($hierarchy as $w): ?>
                                <li class="witel-node">
                                    <div class="node-content"><i class="fa fa-university"></i> WITEL: <?php echo $w['nama_witel']; ?></div>
                                    <ul>
                                        <?php foreach($w['service_areas'] as $sa): ?>
                                            <li class="sa-node">
                                                <div class="node-content"><i class="fa fa-map-signs"></i> SA: <?php echo $sa['nama_service_area']; ?></div>
                                                <ul>
                                                    <?php foreach($sa['sektors'] as $sk): ?>
                                                        <li class="sk-node">
                                                            <div class="node-content"><i class="fa fa-compass"></i> Sektor: <?php echo $sk['nama_sektor']; ?></div>
                                                            <ul>
                                                                <?php foreach($sk['stos'] as $sto): ?>
                                                                    <li class="sto-node">
                                                                        <div class="node-content">
                                                                            <span class="label label-primary" style="font-family:monospace;"><?php echo $sto['kode_sto']; ?></span><br>
                                                                            STO <?php echo $sto['nama_sto']; ?>
                                                                            <?php if(!empty($sto['wilsus'])): ?>
                                                                                <div class="wilsus-container">
                                                                                    <?php $no_ws = 1; foreach($sto['wilsus'] as $ws): ?>
                                                                                        <div class="wilsus-pill" title="Wilsus Area"><?php echo $no_ws++; ?>. <?php echo $ws['nama_wilsus']; ?></div>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.hierarchy-tree { 
    padding: 20px 5px; 
    background: #f8fafc;
    overflow-x: auto; /* Still kept as safety, but we target 1 screen */
    text-align: center;
}

/* Base list styling for tree */
.hierarchy-tree ul {
    padding-top: 20px; 
    position: relative;
    transition: all 0.5s;
    display: flex;
    justify-content: center;
    padding-left: 0;
    margin-bottom: 0;
}

.hierarchy-tree li {
    text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 2px 0 2px; /* Super tight horizontal padding */
    transition: all 0.5s;
    flex: 1; /* Help siblings share space */
}

/* Connecting Lines (Vertical/Top) */
.hierarchy-tree li::before, .hierarchy-tree li::after {
    content: '';
    position: absolute; 
    top: 0; 
    right: 50%;
    border-top: 1.5px solid #cbd5e1;
    width: 50%; 
    height: 20px;
}
.hierarchy-tree li::after {
    right: auto; 
    left: 50%;
    border-left: 1.5px solid #cbd5e1;
}

/* Remove connectors for single child or first/last */
.hierarchy-tree li:only-child::after, .hierarchy-tree li:only-child::before {
    display: none;
}
.hierarchy-tree li:only-child { padding-top: 0; }
.hierarchy-tree li:first-child::before, .hierarchy-tree li:last-child::after {
    border: 0 none;
}
.hierarchy-tree li:last-child::before {
    border-right: 1.5px solid #cbd5e1;
    border-radius: 0 5px 0 0;
}
.hierarchy-tree li:first-child::after {
    border-radius: 5px 0 0 0;
}

/* Vertical line from parent to children */
.hierarchy-tree ul ul::before {
    content: '';
    position: absolute; 
    top: 0; 
    left: 50%;
    border-left: 1.5px solid #cbd5e1;
    width: 0; 
    height: 20px;
}

/* Node Content Styling (Compressed) */
.node-content {
    border: 1.5px solid #cbd5e1;
    padding: 6px 12px;
    text-decoration: none;
    color: #334155;
    font-size: 11px; 
    display: inline-block;
    border-radius: 6px;
    background: #fff;
    transition: all 0.4s;
    font-weight: 700;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    min-width: 100px;
    white-space: nowrap; /* Prevent wrapping for STO names */
    line-height: 1.4;
}

/* Level Specific Colors */
.witel-node > .node-content {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: #fff;
    font-size: 13px;
    border: none;
    min-width: 140px;
}

.sa-node > .node-content {
    background: linear-gradient(135deg, #065f46, #10b981);
    color: #fff;
    border: none;
    min-width: 120px;
}

.sk-node > .node-content {
    background: linear-gradient(135deg, #92400e, #f59e0b);
    color: #fff;
    border: none;
    min-width: 100px;
}

.sto-node > .node-content {
    background: #fff;
    border: 1.5px solid #3b82f6;
    color: #1e3a8a;
    min-width: 90px;
}

/* Wilsus Pills (Numbered & Vertical) */
.wilsus-container {
    display: flex;
    flex-direction: column; /* Stack vertically as per previous request */
    align-items: flex-start; /* Rata Kiri */
    gap: 3px;
    margin-top: 8px;
    border-top: 1px solid #e2e8f0;
    padding-top: 6px;
}

.wilsus-pill {
    background: #fef2f2;
    color: #991b1b;
    padding: 2px 5px;
    border-radius: 3px;
    font-size: 9px;
    border: 1px solid #fecaca;
    font-weight: 500;
}

/* Hover Effects */
.node-content:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}

.witel-node > .node-content:hover, 
.sa-node > .node-content:hover, 
.sk-node > .node-content:hover {
    filter: brightness(1.1);
    color: #ffffff !important;
}

/* Scrollbar Styling */
.hierarchy-tree::-webkit-scrollbar { height: 6px; }
.hierarchy-tree::-webkit-scrollbar-track { background: #f1f1f1; }
.hierarchy-tree::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
</style>

<!-- ====================== MODALS ====================== -->

<!-- Modal Witel -->
<div class="modal fade" id="modalWitel" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#3c8dbc; color:#fff; border:0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-weight:700;">Form Witel</h4>
            </div>
            <form id="formWitel">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group"><label>Nama Witel</label><input type="text" name="nama_witel" class="form-control" required></div>
                </div>
                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Service Area -->
<div class="modal fade" id="modalSA" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#00a65a; color:#fff; border:0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-weight:700;">Form Service Area</h4>
            </div>
            <form id="formSA">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Witel</label>
                        <select name="witel_id" class="form-control" required>
                            <?php foreach($witel as $w): ?><option value="<?php echo $w['id']; ?>"><?php echo $w['nama_witel']; ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Nama Service Area</label><input type="text" name="nama_service_area" class="form-control" required></div>
                </div>
                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sektor -->
<div class="modal fade" id="modalSK" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#f39c12; color:#fff; border:0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-weight:700;">Form Sektor</h4>
            </div>
            <form id="formSK">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Service Area</label>
                        <select name="service_area_id" class="form-control" required>
                            <?php foreach($service_area as $sa): ?><option value="<?php echo $sa['id']; ?>"><?php echo $sa['nama_service_area']; ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Nama Sektor</label><input type="text" name="nama_sektor" class="form-control" required></div>
                </div>
                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-warning btn-block btn-flat" style="color:#fff;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal STO -->
<div class="modal fade" id="modalSTO" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#00c0ef; color:#fff; border:0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-weight:700;">Form STO</h4>
            </div>
            <form id="formSTO">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Sektor</label>
                        <select name="sektor_id" class="form-control" required>
                            <?php foreach($sektor as $sk): ?><option value="<?php echo $sk['id']; ?>"><?php echo $sk['nama_sektor']; ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>Kode STO</label><input type="text" name="kode_sto" class="form-control" required></div></div>
                        <div class="col-md-8"><div class="form-group"><label>Nama STO</label><input type="text" name="nama_sto" class="form-control" required></div></div>
                    </div>
                </div>
                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-info btn-block btn-flat">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Wilsus -->
<div class="modal fade" id="modalWS" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header" style="background:#dd4b39; color:#fff; border:0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="font-weight:700;">Form Wilsus</h4>
            </div>
            <form id="formWS">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>STO</label>
                        <select name="sto_id" class="form-control" required>
                            <?php foreach($sto as $s): ?><option value="<?php echo $s['sto_id']; ?>"><?php echo $s['nama_sto']; ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Nama Wilsus</label><input type="text" name="nama_wilsus" class="form-control" required></div>
                </div>
                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-danger btn-block btn-flat">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Fungsi pembantu untuk penomoran otomatis
    var columnNo = { 
        data: null, 
        sortable: false, 
        render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        } 
    };
    // Init All DataTables
    var t_witel = $('#tblWitel').DataTable({ ajax: BASE_URL+'admin/area/get_witel', columns: [ { data: null, render: function(data, type, row, meta) { return meta.row + 1; } }, {data:'nama_witel'}, {data:'id', render:btnWitel} ] });
    var t_sa    = $('#tblSA').DataTable({ ajax: BASE_URL+'admin/area/get_service_area', columns: [ { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },{data:'nama_service_area'}, {data:'nama_witel'}, {data:'id', render:btnSA} ] });
    var t_sk    = $('#tblSK').DataTable({ ajax: BASE_URL+'admin/area/get_sektor', columns: [ { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },{data:'nama_sektor'}, {data:'nama_service_area'}, {data:'id', render:btnSK} ] });
    var t_sto   = $('#tblSTO').DataTable({ ajax: BASE_URL+'admin/area/get_sto', columns: [ { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },{data:'kode_sto'}, {data:'nama_sto'}, {data:'nama_sektor'}, {data:'id', render:btnSTO} ] });
    var t_ws    = $('#tblWS').DataTable({ ajax: BASE_URL+'admin/area/get_wilsus', columns: [ { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },{data:'nama_wilsus'}, {data:'nama_sto'}, {data:'id', render:btnWS} ] });

    function btnWitel(d){ return '<div class="btn-group"><button class="btn btn-xs btn-default" onclick="editWitel('+d+')"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-danger" onclick="del(\'witel\','+d+')"><i class="fa fa-trash"></i></button></div>'; }
    function btnSA(d){ return '<div class="btn-group"><button class="btn btn-xs btn-default" onclick="editSA('+d+')"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-danger" onclick="del(\'sa\','+d+')"><i class="fa fa-trash"></i></button></div>'; }
    function btnSK(d){ return '<div class="btn-group"><button class="btn btn-xs btn-default" onclick="editSK('+d+')"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-danger" onclick="del(\'sk\','+d+')"><i class="fa fa-trash"></i></button></div>'; }
    function btnSTO(d){ return '<div class="btn-group"><button class="btn btn-xs btn-default" onclick="editSTO('+d+')"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-danger" onclick="del(\'sto\','+d+')"><i class="fa fa-trash"></i></button></div>'; }
    function btnWS(d){ return '<div class="btn-group"><button class="btn btn-xs btn-default" onclick="editWS('+d+')"><i class="fa fa-edit"></i></button><button class="btn btn-xs btn-danger" onclick="del(\'ws\','+d+')"><i class="fa fa-trash"></i></button></div>'; }

    // Forms handling
    $('#formWitel').submit(function(e){ e.preventDefault(); save('witel', $(this), t_witel); });
    $('#formSA').submit(function(e){ e.preventDefault(); save('service_area', $(this), t_sa); });
    $('#formSK').submit(function(e){ e.preventDefault(); save('sektor', $(this), t_sk); });
    $('#formSTO').submit(function(e){ e.preventDefault(); save('sto', $(this), t_sto); });
    $('#formWS').submit(function(e){ e.preventDefault(); save('wilsus', $(this), t_ws); });
});

function addWitel(){ $('#formWitel')[0].reset(); $('#modalWitel input[name=id]').val(''); $('#modalWitel').modal('show'); }
function addSA(){ $('#formSA')[0].reset(); $('#modalSA input[name=id]').val(''); $('#modalSA').modal('show'); }
function addSK(){ $('#formSK')[0].reset(); $('#modalSK input[name=id]').val(''); $('#modalSK').modal('show'); }
function addSTO(){ $('#formSTO')[0].reset(); $('#modalSTO input[name=id]').val(''); $('#modalSTO').modal('show'); }
function addWS(){ $('#formWS')[0].reset(); $('#modalWS input[name=id]').val(''); $('#modalWS').modal('show'); }

function editWitel(id) { $.post(BASE_URL+'admin/area/get_detail_witel', {id:id}, function(res){ var r = JSON.parse(res); $('#formWitel input[name=id]').val(r.id); $('#formWitel input[name=nama_witel]').val(r.nama_witel); $('#modalWitel').modal('show'); }); }
function editSA(id) { $.post(BASE_URL+'admin/area/get_detail_sa', {id:id}, function(res){ var r = JSON.parse(res); $('#formSA input[name=id]').val(r.id); $('#formSA select[name=witel_id]').val(r.witel_id); $('#formSA input[name=nama_service_area]').val(r.nama_service_area); $('#modalSA').modal('show'); }); }
function editSK(id) { $.post(BASE_URL+'admin/area/get_detail_sk', {id:id}, function(res){ var r = JSON.parse(res); $('#formSK input[name=id]').val(r.id); $('#formSK select[name=service_area_id]').val(r.service_area_id); $('#formSK input[name=nama_sektor]').val(r.nama_sektor); $('#modalSK').modal('show'); }); }
function editSTO(id) { $.post(BASE_URL+'admin/area/get_detail_sto', {id:id}, function(res){ var r = JSON.parse(res); $('#formSTO input[name=id]').val(r.id); $('#formSTO select[name=sektor_id]').val(r.sektor_id); $('#formSTO input[name=kode_sto]').val(r.kode_sto); $('#formSTO input[name=nama_sto]').val(r.nama_sto); $('#modalSTO').modal('show'); }); }
function editWS(id) { $.post(BASE_URL+'admin/area/get_detail_ws', {id:id}, function(res){ var r = JSON.parse(res); $('#formWS input[name=id]').val(r.id); $('#formWS select[name=sto_id]').val(r.sto_id); $('#formWS input[name=nama_wilsus]').val(r.nama_wilsus); $('#modalWS').modal('show'); }); }

function save(url, form, table) {
    $.post(BASE_URL+'admin/area/save_'+url, form.serialize(), function(res){
        var r = JSON.parse(res);
        if(r.status=='success') { App.toast(r.message); $(form).closest('.modal').modal('hide'); table.ajax.reload(); }
    });
}

function del(type, id) {
    App.confirm('Hapus?', 'Data yang dihapus tidak bisa dikembalikan.', function(){
        $.post(BASE_URL+'admin/area/delete_any', {type:type, id:id}, function(res){
            var r = JSON.parse(res);
            if(r.status=='success') { App.toast(r.message); location.reload(); } else { App.alert('Error', r.message, 'error'); }
        });
    });
}
</script>
