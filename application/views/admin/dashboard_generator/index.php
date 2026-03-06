<div class="row">
    <div class="col-md-4">
        <div class="box box-primary border-0 shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-plus-circle text-primary"></i> Widget Configuration</h3>
            </div>
            <form id="formWidget">
                <div class="box-body" style="padding: 20px;">
                    <input type="hidden" name="id" id="widgetId">
                    
                    <div class="form-group">
                        <label>Judul Widget <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: TOTAL MITRA AKTIF" required>
                    </div>

                    <div class="form-group">
                        <label>Tipe Visual <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="stat_box">Stat Info Box (Angka Cepat)</option>
                            <option value="line_chart">Line Chart (Trend Bulanan)</option>
                            <option value="pie_chart">Pie Chart (Distribusi Data)</option>
                            <option value="recent_list">Recent Activity List</option>
                            <option value="pivot_table">Pivot Summary Table</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Target Tabel Database <span class="text-danger">*</span></label>
                        <select name="table_source" id="table_source" class="form-control" required>
                            <?php foreach ($tables as $t): ?>
                            <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="calc-area">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Kalkulasi</label>
                                    <select name="calc_type" id="calc_type" class="form-control">
                                        <option value="COUNT">COUNT (Jumlah)</option>
                                        <option value="SUM">SUM (Total Nilai)</option>
                                        <option value="AVG">AVG (Rata-rata)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kolom Target</label>
                                    <input type="text" name="calc_field" id="calc_field" class="form-control" placeholder="id / price / dll">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gaya Visual (Warna)</label>
                                <select name="color" id="color" class="form-control">
                                    <option value="blue">Blue (Primary)</option>
                                    <option value="green">Green (Success)</option>
                                    <option value="yellow">Yellow (Warning)</option>
                                    <option value="red">Red (Danger)</option>
                                    <option value="purple">Purple</option>
                                    <option value="teal">Teal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Icon (FontAwesome)</label>
                                <input type="text" name="icon" id="icon" class="form-control" value="fa-cube" placeholder="fa-user">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ukuran Grid (1-12)</label>
                                <input type="number" name="grid_size" id="grid_size" class="form-control" value="3" min="1" max="12">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Urutan Tampilan</label>
                                <input type="number" name="order_num" id="order_num" class="form-control" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="checkbox">
                        <label><input type="checkbox" name="is_active" id="is_active" value="1" checked> Aktifkan Widget ini di Dashboard</label>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat btn-block"><i class="fa fa-save"></i> SIMPAN WIDGET</button>
                    <button type="button" class="btn btn-default btn-flat btn-block" onclick="resetForm()">BATAL / RESET</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-primary border-0 shadow-sm">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-th text-muted"></i> Active Widgets List</h3>
            </div>
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr class="bg-gray-light">
                            <th width="30">#</th>
                            <th>Info Widget</th>
                            <th>Tabel Sumber</th>
                            <th class="text-center">Grid</th>
                            <th class="text-center">Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($widgets)): ?>
                        <tr><td colspan="6" class="text-center text-muted italic" style="padding: 20px;">Belum ada widget. Silakan buat satu di sebelah kiri.</td></tr>
                        <?php else: foreach ($widgets as $w): ?>
                        <tr>
                            <td><?php echo $w['order_num']; ?></td>
                            <td>
                                <div style="display:flex; align-items:center;">
                                    <div style="width:30px; height:30px; border-radius:4px; background:<?php echo $w['color']; ?>; color:#fff; display:flex; align-items:center; justify-content:center; margin-right:10px;">
                                        <i class="fa <?php echo $w['icon']; ?>"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:700;"><?php echo $w['title']; ?></div>
                                        <div class="small text-muted"><?php echo strtoupper(str_replace('_', ' ', $w['type'])); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code><?php echo $w['table_source']; ?></code></td>
                            <td class="text-center"><span class="badge bg-gray"><?php echo $w['grid_size']; ?>/12</span></td>
                            <td class="text-center">
                                <?php if ($w['is_active']): ?>
                                <span class="text-success"><i class="fa fa-check-circle"></i> Active</span>
                                <?php else: ?>
                                <span class="text-muted"><i class="fa fa-circle-o"></i> Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-default btn-flat" onclick="editWidget(<?php echo $w['id']; ?>)" title="Edit"><i class="fa fa-pencil text-warning"></i></button>
                                <button class="btn btn-sm btn-default btn-flat" onclick="deleteWidget(<?php echo $w['id']; ?>)" title="Hapus"><i class="fa fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function resetForm() {
    $('#formWidget')[0].reset();
    $('#widgetId').val('');
}

$('#formWidget').submit(function(e) {
    e.preventDefault();
    App.showLoader();
    $.post(BASE_URL + 'admin/dashboard_generator/save', $(this).serialize(), function(res) {
        App.hideLoader();
        var r = JSON.parse(res);
        if (r.status == 'success') {
            App.toast(r.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            App.alert('Error', r.message, 'error');
        }
    });
});

function editWidget(id) {
    $.post(BASE_URL + 'admin/dashboard_generator/get_widget_data', {id: id}, function(res) {
        var d = JSON.parse(res);
        $('#widgetId').val(d.id);
        $('#title').val(d.title);
        $('#type').val(d.type);
        $('#table_source').val(d.table_source);
        $('#calc_type').val(d.calc_type);
        $('#calc_field').val(d.calc_field);
        $('#color').val(d.color);
        $('#icon').val(d.icon);
        $('#grid_size').val(d.grid_size);
        $('#order_num').val(d.order_num);
        if (d.is_active == 1) $('#is_active').prop('checked', true);
        else $('#is_active').prop('checked', false);
        
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        App.toast('Data widget dimuat.', 'info');
    });
}

function deleteWidget(id) {
    App.confirm('Hapus Widget?', 'Widget ini tidak akan muncul lagi di Dashboard.', function() {
        $.post(BASE_URL + 'admin/dashboard_generator/delete', {id: id}, function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    });
}
</script>
