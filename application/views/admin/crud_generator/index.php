<style>
    .code-block {
        background: #1e293b;
        color: #e2e8f0;
        padding: 15px;
        border-radius: 8px;
        font-family: 'Consolas', monospace;
        font-size: 12px;
        min-height: 400px;
        max-height: 500px;
        overflow-y: auto;
        white-space: pre-wrap;
        border: 1px solid #0f172a;
    }
    .custom-switch { display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .custom-switch input { width: 20px; height: 20px; cursor: pointer; }
    .custom-switch span { font-weight: 600; color: #1e293b; }
</style>

<div class="row">
    <div class="col-md-5">
        <div class="box box-primary border-0 shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-magic text-primary"></i> Parameter Generator</h3>
            </div>
            <form id="formGenerator">
                <div class="box-body" style="padding: 20px;">
                    <div class="callout callout-info" style="border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-info-circle"></i> Mesin ini akan menyusun struktur <b>MVC (Model, View, Controller)</b> standar *Enterprise* secara otomatis berpedoman pada `create_module.md`.
                    </div>
                
                    <div class="form-group">
                        <label>Strategi Tabel Database <span class="text-danger">*</span></label>
                        <div class="radio">
                            <label><input type="radio" name="table_mode" value="existing" checked onclick="$('#opt-new').hide(); $('#opt-existing').show();"> Gunakan Tabel yang Sedang Ada</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="table_mode" value="new" onclick="$('#opt-existing').hide(); $('#opt-new').fadeIn();"> Buat Tabel Baru & Generate Sekaligus</label>
                        </div>
                    </div>

                    <div id="opt-existing">
                        <div class="form-group" style="background: #f1f5f9; border:1px solid #e2e8f0; padding:15px; border-radius:8px; margin-bottom: 15px;">
                            <label>Koneksi Database (Sumber Tabel) <span class="text-danger">*</span></label>
                            <div class="radio" style="margin-top: 5px;">
                                <label><input type="radio" name="db_group" value="default" checked onchange="fetchTables('default')"> Database Default (Aplikasi Saat Ini)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="db_group" value="db_lama" onchange="fetchTables('db_lama')"> Database Sekunder (<code>db_lama</code>)</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Target Database Table</label>
                            <select name="table_name" class="form-control">
                                <option value="">— Pilih Tabel Data —</option>
                                <?php if (isset($tables)): foreach ($tables as $t): ?>
                                <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                            <small class="text-muted">Tabel target wajib memiliki field (id, deleted_at).</small>
                        </div>
                    </div>

                    <div id="opt-new" style="display:none; background: #f8fafc; border:1px solid #e2e8f0; padding:15px; border-radius:8px; margin-bottom: 20px;">
                        <div class="form-group">
                            <label>Nama Tabel Baru (huruf_kecil_spasi_bawah)</label>
                            <input type="text" name="new_table_name" class="form-control" placeholder="contoh: trx_inventaris_barang">
                        </div>
                        
                        <label>Struktur Kolom Data Secara Kustom</label>
                        <table class="table table-bordered table-condensed bg-white" id="tblFields">
                            <thead>
                                <tr class="bg-gray-light">
                                    <th>Nama Kolom (Kecil)</th>
                                    <th width="110">Tipe</th>
                                    <th width="70">Len</th>
                                    <th width="70" class="text-center">Null</th>
                                    <th width="40"></th>
                                </tr>
                            </thead>
                            <tbody id="fieldList">
                                <tr>
                                    <td><input type="text" name="field_name[]" class="form-control input-sm" placeholder="nama_kategori"></td>
                                    <td>
                                        <select name="field_type[]" class="form-control input-sm">
                                            <option value="VARCHAR">VARCHAR</option>
                                            <option value="INT">INT</option>
                                            <option value="TEXT">TEXT</option>
                                            <option value="DATE">DATE</option>
                                            <option value="DATETIME">DATETIME</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="field_length[]" class="form-control input-sm" value="255"></td>
                                    <td>
                                        <select name="field_null[]" class="form-control input-sm">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </td>
                                    <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-flat" onclick="$(this).closest('tr').remove()"><i class="fa fa-times"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-sm btn-default btn-flat" id="btnAddField"><i class="fa fa-plus text-primary"></i> Tambah Kolom</button>
                                        <small class="text-muted" style="display:block; margin-top:5px;">* Kolom `id`, `created_at`, `updated_at`, `deleted_at`<br> <b>OTOMATIS</b> dibuat oleh mesin.</small>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="form-group">
                        <label>Class/Module Name <span class="text-danger">*</span></label>
                        <input type="text" name="module_name" class="form-control" placeholder="Contoh: Kategori Tiket" required>
                        <small class="text-muted">Gunakan spasi atau kapital sesuai UI target. Nanti dikonversi otomatis.</small>
                    </div>

                    <hr>
                    <label>Penempatan Navigasi Sistem <span class="text-danger">*</span></label>
                    <div class="form-group" style="background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0;">
                         <div class="radio" style="margin-top:0;">
                            <label><input type="radio" name="menu_mode" value="existing_parent" checked onclick="$('#opt-new-parent').hide(); $('#opt-existing-parent').show();"> Masukkan ke Kategori Menu Induk yang Ada</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="menu_mode" value="new_parent" onclick="$('#opt-existing-parent').hide(); $('#opt-new-parent').fadeIn();"> Buat Kategori Menu Induk Baru</label>
                        </div>

                        <div id="opt-existing-parent" style="margin-top:10px;">
                            <select name="parent_id" class="form-control">
                                <?php if (isset($parents)): foreach ($parents as $p): ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['menu_name']; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        
                        <div id="opt-new-parent" style="display:none; margin-top:10px;">
                            <input type="text" name="new_parent_name" class="form-control" placeholder="Nama Kategori Induk Baru (Cth: Inventori Server)">
                            <div class="input-group" style="margin-top:10px;">
                                <span class="input-group-addon"><i class="fa fa-fonticons"></i></span>
                                <input type="text" name="new_parent_icon" class="form-control" placeholder="Icon FontAwesome (Opsional, Default: fa-folder)">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 25px; padding: 15px; background: #e0f2fe; border-radius: 8px; border: 1px solid #bae6fd;">
                        <label class="custom-switch">
                            <input type="checkbox" name="enable_excel" id="enableExcel" value="1">
                            <span><i class="fa fa-file-excel-o text-success"></i> Aktifkan Fitur Import Excel</span>
                        </label>
                        <p class="text-muted small" style="margin: 5px 0 0 30px;">
                            Jika dicentang, modul akan memiliki fitur upload Excel dengan jendela *Review & Validation* sebelum disimpan.
                        </p>
                    </div>

                    <div class="form-group" style="margin-top: 10px; padding: 15px; background: #fefce8; border-radius: 8px; border: 1px solid #fef08a;">
                        <label class="custom-switch">
                            <input type="checkbox" name="generate_to_file" id="autoInstall" value="1">
                            <span><i class="fa fa-download text-primary"></i> Auto-Install (Tulis ke Server)</span>
                        </label>
                        <p class="text-muted small" style="margin: 5px 0 0 30px;">
                            Jika dicentang, mesin akan mensintesis file `.php` aktual dan menyebarkannya ke arsitektur MVC.
                        </p>
                    </div>
                </div>
                <div class="box-footer" style="padding: 20px;">
                    <button type="submit" class="btn btn-primary btn-flat btn-block"><i class="fa fa-cogs"></i> GENERATE CORE</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="nav-tabs-custom shadow-sm" style="border-radius: 8px; overflow: hidden;">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-server text-blue"></i> Controller (Logic)</a></li>
                <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-database text-green"></i> Model (Core DB)</a></li>
                <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-desktop text-orange"></i> View (UI/UX)</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <pre class="code-block" id="resController"><span class="text-muted">// Ready for compilation...</span></pre>
                </div>
                <div class="tab-pane" id="tab_2">
                    <pre class="code-block" id="resModel"><span class="text-muted">// Ready for compilation...</span></pre>
                </div>
                <div class="tab-pane" id="tab_3">
                    <pre class="code-block" id="resView"><span class="text-muted">// Ready for compilation...</span></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fetchTables(db_group) {
    if ($('input[name="table_mode"]:checked').val() == 'new') return;
    
    var select = $('select[name="table_name"]');
    select.empty();
    select.append('<option value="">— Sedang Memuat Tabel... —</option>');
    
    $.post(BASE_URL + 'admin/crud_generator/get_tables_ajax', {db_group: db_group}, function(res) {
        try {
            var tables = JSON.parse(res);
            select.empty();
            select.append('<option value="">— Pilih Tabel Data —</option>');
            if (tables.length > 0) {
                tables.forEach(function(t) {
                    select.append('<option value="' + t + '">' + t + '</option>');
                });
            } else {
                select.append('<option value="">— Tidak Ditemukan Tabel —</option>');
            }
        } catch(e) {
            App.alert('Error', 'Gagal memuat tabel dari database ' + db_group, 'error');
            select.empty().append('<option value="">— Gagal Memuat Tabel —</option>');
        }
    });
}

$(function(){
    $('#btnAddField').click(function(){
        $('#fieldList').append(`
            <tr>
                <td><input type="text" name="field_name[]" class="form-control input-sm" placeholder="kolom_kustom"></td>
                <td>
                    <select name="field_type[]" class="form-control input-sm">
                        <option value="VARCHAR">VARCHAR</option>
                        <option value="INT">INT</option>
                        <option value="TEXT">TEXT</option>
                        <option value="DATE">DATE</option>
                        <option value="DATETIME">DATETIME</option>
                    </select>
                </td>
                <td><input type="number" name="field_length[]" class="form-control input-sm" value="255"></td>
                <td>
                    <select name="field_null[]" class="form-control input-sm">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-flat" onclick="$(this).closest('tr').remove()"><i class="fa fa-times"></i></button></td>
            </tr>
        `);
    });

    $('#formGenerator').submit(function(e){
        e.preventDefault();
        
        $('#resController').html('<i class="fa fa-refresh fa-spin text-primary"></i> Compiling Logic...');
        $('#resModel').html('<i class="fa fa-refresh fa-spin text-primary"></i> Compiling DB Architecture...');
        $('#resView').html('<i class="fa fa-refresh fa-spin text-primary"></i> Compiling View Interfaces...');

        $.post(BASE_URL + 'admin/crud_generator/generate', $(this).serialize(), function(res){
            App.hideLoader();
            try {
                var r = JSON.parse(res);
                if(r.status == 'success') {
                    App.alert('Pemasangan Modul Sukses!', r.message, 'success');
                    if(!$('#autoInstall').is(':checked')) {
                        var decodedC = $('<textarea>').html(r.controller).text();
                        var decodedM = $('<textarea>').html(r.model).text();
                        var decodedV = $('<textarea>').html(r.view).text();
                        $('#resController').text(decodedC);
                        $('#resModel').text(decodedM);
                        $('#resView').text(decodedV);
                    } else {
                        $('#resController').html('<strong class="text-success"><i class="fa fa-check"></i> Files Saved to Disk! Controller Deployed.</strong>');
                        $('#resModel').html('<strong class="text-success"><i class="fa fa-check"></i> Files Saved to Disk! Model Deployed.</strong>');
                        $('#resView').html('<strong class="text-success"><i class="fa fa-check"></i> Files Saved to Disk! View Deployed.</strong>');
                    }
                    
                    // Reload window agar list menu navigasi update
                    if ($('#autoInstall').is(':checked') || $('input[name=table_mode]:checked').val() == 'new') {
                        setTimeout(() => window.location.reload(), 2000);
                    }
                } else {
                    App.alert('Operasi Terhenti', r.message, 'error');
                    $('#resController, #resModel, #resView').text('Error: ' + r.message);
                }
            } catch (e) {
                App.alert('Fatal Fault', 'Gagal memproses respon server.', 'error');
                console.error(res);
            }
        }).fail(function(){
            App.hideLoader();
            App.alert('Connection Error', 'Koneksi ke server terputus.', 'error');
        });
    });
});
</script>
