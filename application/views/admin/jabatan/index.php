<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary border-0 shadow-sm">
            <div class="box-header with-border" style="padding: 15px 20px;">
                <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-briefcase text-primary"></i> Data Jabatan</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm btn-flat" onclick="showAddModal()"><i class="fa fa-plus"></i> Tambah Jabatan</button>
                </div>
            </div>
            <div class="box-body" style="padding: 20px;">
                <table class="table table-hover table-striped" id="tblJabatan">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Jabatan</th>
                            <th>Deskripsi</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($jabatan as $j): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?php echo $j['nama_jabatan']; ?></td>
                            <td class="text-muted"><?php echo $j['deskripsi']; ?></td>
                            <td class="text-center">
                                <button class="btn btn-default btn-xs btn-flat" onclick="editData(<?php echo $j['id']; ?>)" title="Edit"><i class="fa fa-pencil text-warning"></i></button>
                                <button class="btn btn-default btn-xs btn-flat" onclick="deleteData(<?php echo $j['id']; ?>)" title="Delete"><i class="fa fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add/Edit -->
<div class="modal fade" id="modalJabatan" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary shadow-sm" style="border:0;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" id="modalTitle" style="color:#fff; font-weight: 600;">Tambah Jabatan</h4>
            </div>
            <form id="formJabatan">
                <input type="hidden" name="id" id="jabatanId">
                <div class="modal-body" style="padding: 25px;">
                    <div class="form-group">
                        <label>Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jabatan" id="namaJabatan" class="form-control" placeholder="Contoh: Teknisi Fiber Optik" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Tugas</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi mengenai ruang lingkup jabatan ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-gray-light">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var editMode = false;

$(function() {
    $('#tblJabatan').DataTable({
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>',
        "language": { "search": "Cari:" }
    });

    $('#formJabatan').submit(function(e) {
        e.preventDefault();
        var url = editMode ? BASE_URL + 'admin/jabatan/update' : BASE_URL + 'admin/jabatan/add';
        
        $.post(url, $(this).serialize(), function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                $('#modalJabatan').modal('hide');
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    });
});

function showAddModal() {
    editMode = false;
    $('#modalTitle').text('Registrasi Jabatan Baru');
    $('#formJabatan')[0].reset();
    $('#jabatanId').val('');
    $('#modalJabatan').modal('show');
}

function editData(id) {
    editMode = true;
    $.post(BASE_URL + 'admin/jabatan/get_jabatan', {id: id}, function(res) {
        var data = JSON.parse(res);
        $('#modalTitle').text('Edit Jabatan: ' + data.nama_jabatan);
        $('#jabatanId').val(data.id);
        $('#namaJabatan').val(data.nama_jabatan);
        $('#deskripsi').val(data.deskripsi);
        $('#modalJabatan').modal('show');
    });
}

function deleteData(id) {
    App.confirm('Peringatan Hapus', 'Apakah Anda yakin ingin menghapus data jabatan ini? (Soft Delete)', function() {
        $.post(BASE_URL + 'admin/jabatan/delete', {id: id}, function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Gagal', r.message, 'error');
            }
        });
    }, 'warning');
}
</script>
