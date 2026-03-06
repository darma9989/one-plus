<style>
    .role-card { border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 8px; overflow: hidden; margin-bottom: 25px; }
    .role-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); }
    .role-card .box-header { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; }
    .role-card .box-title { font-weight: 700; color: #1e293b; font-size: 16px; }
    .role-card .box-body { padding: 20px; min-height: 100px; }
    .role-card .box-footer { background: #f8fafc; padding: 0; border-top: 1px solid #f1f5f9; display: flex; }
    .role-card .btn-role { flex: 1; border-radius: 0; padding: 12px; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; border: none; background: transparent; color: #64748b; border-right: 1px solid #f1f5f9; }
    .role-card .btn-role:last-child { border-right: none; }
    .role-card .btn-role:hover { background: #fff; color: #3b82f6; }
    .role-card .btn-role-danger:hover { color: #ef4444; }
    
    .perm-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .perm-table th { background: #f8fafc; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 12px 15px; border-bottom: 2px solid #e2e8f0; }
    .perm-table td { padding: 12px 15px; border-bottom: 1px solid #f1f5f9; transition: all 0.2s; }
    .perm-table tr:hover td { background: #fdfdfd; }
    .perm-parent { background: #f8fafc; font-weight: 700; color: #1e293b; }
    .perm-child { padding-left: 45px !important; color: #475569; }
    
    .status-system { background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; }
    .count-badge { background: #e0f2fe; color: #075985; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: 600; }

    /* Custom Checkbox Styling */
    .switch-checkbox { position: relative; display: inline-block; width: 40px; height: 20px; margin-bottom: 0; vertical-align: middle; }
    .switch-checkbox input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: #3b82f6; }
    input:checked + .slider:before { transform: translateX(20px); }
</style>

<div class="row">
    <div class="col-md-12" style="margin-bottom: 25px;">
        <div class="pull-left">
            <h3 style="margin-top:0; font-weight: 700;"><i class="fa fa-shield text-primary"></i> Role Access Management</h3>
            <p class="text-muted">Configure access titles and permission matrix for all system levels.</p>
        </div>
        <div class="pull-right" style="margin-top: 20px;">
            <button class="btn btn-primary btn-flat" onclick="showAddRole()"><i class="fa fa-plus"></i> Create New Role</button>
        </div>
    </div>
</div>

<div class="box box-primary border-0 shadow-sm">
    <div class="box-body" style="padding: 20px;">
        <table class="table table-hover table-striped" id="tblRoles" style="width: 100%;">
            <thead>
                <tr>
                    <th width="30" class="text-center">No</th>
                    <th width="180">Nama Role & Akses</th>
                    <th width="250">Deskripsi / Tujuan</th>
                    <th width="120" class="text-center">Tipe Hak</th>
                    <th width="150" class="text-center">Pengguna (Users)</th>
                    <th width="180" class="text-right">Aksi & Ototrisasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($roles)): $no=1; foreach ($roles as $r): ?>
                <tr>
                    <td class="text-center align-middle"><?php echo $no++; ?></td>
                    <td class="align-middle">
                        <strong style="color: #1e293b; font-size: 14px;"><i class="fa fa-shield text-muted"></i> <?php echo $r['role_name']; ?></strong>
                    </td>
                    <td class="align-middle text-muted" style="font-size: 12px;">
                        <?php echo $r['description'] ? $r['description'] : '<i>Belum ada deskripsi spesifik.</i>'; ?>
                    </td>
                    <td class="text-center align-middle">
                        <?php if ($r['is_superadmin']): ?>
                            <span class="status-system">SYSTEM ROOT</span>
                        <?php else: ?>
                            <span class="label" style="background: #e2e8f0; color: #475569; font-weight: 600;">CUSTOM ROLE</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center align-middle">
                        <span class="count-badge"><i class="fa fa-users"></i> <?php echo $r['user_count']; ?> Akun</span>
                    </td>
                    <td class="text-right align-middle">
                        <button class="btn btn-sm btn-flat btn-primary" onclick='showPermissions(<?php echo $r['id']; ?>, <?php echo htmlspecialchars(json_encode($r['role_name']), ENT_QUOTES, "UTF-8"); ?>)' title="Atur Matrix Hak Akses Menu"><i class="fa fa-key"></i> Hak Akses</button>
                        
                        <?php if (!$r['is_superadmin']): ?>
                            <button class="btn btn-sm btn-flat btn-default" onclick='editRole(<?php echo $r['id']; ?>, <?php echo htmlspecialchars(json_encode($r['role_name']), ENT_QUOTES, "UTF-8"); ?>, <?php echo htmlspecialchars(json_encode((string)$r['description']), ENT_QUOTES, "UTF-8"); ?>, <?php echo $r['can_add_user']; ?>, <?php echo $r['can_view_all_users']; ?>)' title="Edit Nama Role"><i class="fa fa-pencil text-warning"></i></button>
                            <button class="btn btn-sm btn-flat btn-default" onclick="deleteRole(<?php echo $r['id']; ?>)" title="Hapus Role"><i class="fa fa-trash text-danger"></i></button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-flat btn-default disabled" style="opacity: 0.4;" title="Role Sistem terkunci"><i class="fa fa-lock"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Role -->
<div class="modal fade" id="modalRole">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary shadow-sm">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" id="roleFormTitle" style="color:#fff; font-weight: 600;">Manage Role</h4>
            </div>
            <form id="formRole">
                <div class="modal-body" style="padding: 25px;">
                    <input type="hidden" name="id" id="roleId">
                    <div class="form-group">
                        <label style="color:#64748b;">Role Identity Name <span class="text-danger">*</span></label>
                        <input type="text" name="role_name" id="roleName" class="form-control" placeholder="e.g. Sales Manager" required>
                    </div>
                    <div class="form-group">
                        <label style="color:#64748b;">Description (Optional)</label>
                        <textarea name="description" id="roleDesc" class="form-control" rows="3" placeholder="Explain the purpose of this role..."></textarea>
                    </div>
                    <div class="form-group" style="padding-top: 15px; border-top: 1px dashed #e2e8f0;">
                        <label style="color:#64748b; display:block; margin-bottom: 15px;">Advanced Capabilities</label>
                        <div class="checkbox" style="margin-top: 0; margin-bottom: 10px;">
                            <label style="font-weight: normal; color: #475569;">
                                <input type="checkbox" name="can_view_all_users" id="canViewAllUsers" value="1" style="margin-top: 2px;"> 
                                <b style="color: #1e293b;">View All Users</b> &mdash; See and modify all users in the system (not just their own profile).
                            </label>
                        </div>
                        <div class="checkbox">
                            <label style="font-weight: normal; color: #475569;">
                                <input type="checkbox" name="can_add_user" id="canAddUser" value="1" style="margin-top: 2px;"> 
                                <b style="color: #1e293b;">Create Users</b> &mdash; Allow creation of new user profiles.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-gray-light">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Permission Matrix -->
<div class="modal fade" id="modalPermission">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-navy shadow-sm">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" style="color:#fff; font-weight:600;"><i class="fa fa-shield"></i> Privilege Matrix — <span id="permRoleName"></span></h4>
            </div>
            <form id="formPermissions">
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <input type="hidden" name="role_id" id="permRoleId">
                    <table class="perm-table">
                        <thead>
                            <tr>
                                <th>Module / Menu Name</th>
                                <th width="150" class="text-center">Access Grant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($menus)): ?>
                            <?php foreach ($menus as $m): ?>
                            <tr class="perm-parent">
                                <td><i class="<?php echo $m['menu_icon']; ?> fa-fw"></i> <?php echo $m['menu_name']; ?></td>
                                <td class="text-center">
                                    <label class="switch-checkbox">
                                        <input type="checkbox" name="menu_ids[]" value="<?php echo $m['id']; ?>" class="perm-check parent-check" data-parent="<?php echo $m['id']; ?>">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php if (isset($m['children'])): foreach ($m['children'] as $child): ?>
                            <tr class="perm-row">
                                <td class="perm-child"><i class="fa fa-angle-right text-gray"></i> <i class="<?php echo $child['menu_icon']; ?> fa-fw"></i> <?php echo $child['menu_name']; ?></td>
                                <td class="text-center">
                                    <label class="switch-checkbox">
                                        <input type="checkbox" name="menu_ids[]" value="<?php echo $child['id']; ?>" class="perm-check child-check" data-master="<?php echo $m['id']; ?>">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-gray-light">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default btn-sm btn-flat" onclick="$('.perm-check').prop('checked',true)"><i class="fa fa-check-square-o"></i> Select All</button>
                        <button type="button" class="btn btn-default btn-sm btn-flat" onclick="$('.perm-check').prop('checked',false)"><i class="fa fa-square-o"></i> Deselect All</button>
                    </div>
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Applied Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var roleEditMode = false;

$(function(){
    $('#tblRoles').DataTable({
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>',
        "language": { "search": "Pencarian Role:" },
        "columnDefs": [ { "targets": 5, "orderable": false } ]
    });

    // Helper to auto check parent if child is checked
    $('.child-check').change(function(){
        if(this.checked){
            var masterId = $(this).data('master');
            $('.parent-check[data-parent="'+masterId+'"]').prop('checked', true);
        }
    });
    
    // Helper to auto check all children if parent is checked
    $('.parent-check').change(function(){
        var parentId = $(this).data('parent');
        $('.child-check[data-master="'+parentId+'"]').prop('checked', this.checked);
    });
});

function showAddRole(){
    roleEditMode = false;
    $('#roleFormTitle').text('Create System Role');
    $('#formRole')[0].reset();
    $('#roleId').val('');
    $('#canAddUser').prop('checked', false);
    $('#canViewAllUsers').prop('checked', false);
    $('#modalRole').modal('show');
}

function editRole(id, name, desc, canAdd, canView){
    roleEditMode = true;
    $('#roleFormTitle').text('Modify System Role');
    $('#roleId').val(id);
    $('#roleName').val(name);
    $('#roleDesc').val(desc);
    $('#canAddUser').prop('checked', canAdd == 1);
    $('#canViewAllUsers').prop('checked', canView == 1);
    $('#modalRole').modal('show');
}

$('#formRole').submit(function(e){
    e.preventDefault();
    var url = roleEditMode ? BASE_URL+'admin/roles/update' : BASE_URL+'admin/roles/add';
    $.post(url, $(this).serialize(), function(res){
        var r = JSON.parse(res);
        if(r.status=='success'){
            $('#modalRole').modal('hide');
            App.toast(r.message, 'success');
            setTimeout(function(){ location.reload(); }, 1500);
        } else {
            App.alert('Error', r.message, 'error');
        }
    });
});

function deleteRole(id){
    App.confirm('Terminate Role Access?', 'Warning: This will revoke access for all users assigned to this role.', function(){
        $.post(BASE_URL+'admin/roles/delete', {id:id}, function(res){
            var r = JSON.parse(res);
            if(r.status=='success'){
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    }, 'warning');
}

function showPermissions(roleId, roleName){
    $('#permRoleId').val(roleId);
    $('#permRoleName').text(roleName);
    $('.perm-check').prop('checked', false);
    
    // Show loading or something?
    $.post(BASE_URL+'admin/roles/get_permissions', {role_id: roleId}, function(res){
        var perms = JSON.parse(res);
        $.each(perms, function(i, mid){
            $('.perm-check[value="'+mid+'"]').prop('checked', true);
        });
        $('#modalPermission').modal('show');
    });
}

$('#formPermissions').submit(function(e){
    e.preventDefault();
    $.post(BASE_URL+'admin/roles/save_permissions', $(this).serialize(), function(res){
        var r = JSON.parse(res);
        if(r.status=='success'){
            $('#modalPermission').modal('hide');
            App.toast(r.message, 'success');
        } else {
            App.alert('Error', r.message, 'error');
        }
    });
});
</script>
