<!-- Data Table Box -->
<div class="box box-primary border-0 shadow-sm">
    <div class="box-header with-border" style="padding: 15px 20px;">
        <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-list text-primary"></i> Data Material</h3>
        <div class="pull-right">
            <div class="btn-group" style="margin-right: 5px;">
                <button type="button" class="btn btn-success btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i> Tools <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="javascript:void(0)" onclick="showImportModal()"><i class="fa fa-upload"></i> Import Excel</a></li>
                    <li><a href="javascript:void(0)" onclick="exportExcel()"><i class="fa fa-download"></i> Export Excel</a></li>
                </ul>
            </div>
            <button class="btn btn-primary btn-sm btn-flat" onclick="showAddModal()"><i class="fa fa-plus"></i> Tambah Data Baru</button>
        </div>
    </div>
    <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="tblData" style="width: 100%;">
                <thead>
                    <tr class="bg-gray-light">
                        <th width="30" class="text-center">No</th>
                        <th>Designator</th>
                        <th>Nama material</th>
                        <th>Satuan</th>
                        <th width="100" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($records)): $no=1; foreach ($records as $r): ?>
                    <tr>
                        <td class="text-center align-middle"><?php echo $no++; ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['designator']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['nama_material']); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars($r['satuan']); ?></td>
                        <td class="text-center align-middle">
                            <button class="btn btn-sm btn-flat btn-default" onclick="editData(<?php echo $r['id_list_material_wh']; ?>)" title="Edit"><i class="fa fa-pencil text-warning"></i></button>
                            <button class="btn btn-sm btn-flat btn-default" onclick="deleteData(<?php echo $r['id_list_material_wh']; ?>)" title="Hapus"><i class="fa fa-trash text-danger"></i></button>
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
            <div class="modal-header bg-primary shadow-sm" style="border:0">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" id="modalTitle" style="color:#fff; font-weight: 600;">Form Material</h4>
            </div>
            <form id="formData">
                <div class="modal-body" style="padding: 25px;">
                    <input type="hidden" name="id" id="dataId">
                    <div class="form-group">
                        <label>Designator <span class="text-danger">*</span></label>
                        <input type="text" name="designator" id="designator" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama material <span class="text-danger">*</span></label>
                        <input type="text" name="nama_material" id="nama_material" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" id="satuan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-gray-light">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImport" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-green shadow-sm" style="border:0">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" style="color:#fff; font-weight: 600;"><i class="fa fa-file-excel-o"></i> Import Data Material</h4>
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
            <div class="modal-footer bg-gray-light">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success btn-flat" id="btnProcessImport" style="display:none;"><i class="fa fa-check"></i> Simpan Semua Data</button>
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
    $('#modalTitle').text('Tambah Data Material');
    $('#formData')[0].reset();
    $('#dataId').val('');
    $('#modalForm').modal('show');
}

function editData(id) {
    $.post(BASE_URL + 'admin/material/get_data', {id: id}, function(res) {
        var d = JSON.parse(res);
        $('#modalTitle').text('Edit Data Material');
        $('#dataId').val(d.id_list_material_wh);
        $('#designator').val(d.designator);
        $('#nama_material').val(d.nama_material);
        $('#satuan').val(d.satuan);
        $('#modalForm').modal('show');
    });
}

$('#formData').submit(function(e) {
    e.preventDefault();
    App.showLoader();
    $.post(BASE_URL + 'admin/material/save', $(this).serialize(), function(res) {
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
        $.post(BASE_URL + 'admin/material/delete', {id: id}, function(res) {
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
        $.post(BASE_URL + 'admin/material/import_excel', {data: importedData}, function(res) {
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
    XLSX.utils.book_append_sheet(wb, ws, 'Data Material');
    XLSX.writeFile(wb, 'Export_Data_Material_' + new Date().getTime() + '.xlsx');
}
</script>
