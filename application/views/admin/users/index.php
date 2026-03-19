<style>
    :root {
        --mac-bg: #1c1c1e;
        --mac-card: #2c2c2e;
        --mac-card-header: rgba(44, 44, 46, 0.8);
        --mac-text: #ffffff;
        --mac-text-dim: #a1a1a6;
        --mac-border: #38383a;
        --mac-blue: #0A84FF;
        --mac-green: #30D158;
        --mac-red: #FF453A;
        --mac-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    body {
        background-color: var(--mac-bg) !important;
        color: var(--mac-text) !important;
    }

    .content-wrapper {
        background-color: var(--mac-bg) !important;
    }

    /* Modern Info Box */
    .info-box {
        background: var(--mac-card) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        box-shadow: var(--mac-shadow) !important;
        color: var(--mac-text) !important;
        overflow: hidden;
    }

    .info-box-icon {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #fff !important;
    }

    .info-box-text { 
        text-transform: uppercase; 
        font-weight: 600; 
        font-size: 11px; 
        color: var(--mac-text-dim) !important; 
    }
    
    .info-box-number { 
        font-size: 24px; 
        font-weight: 700; 
        color: var(--mac-text) !important;
    }

    /* Modern Card Layout */
    .box {
        background: var(--mac-card) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        box-shadow: var(--mac-shadow) !important;
        overflow: hidden;
        color: var(--mac-text) !important;
    }

    .box-header {
        background: var(--mac-card-header) !important;
        border-bottom: 1px solid var(--mac-border) !important;
        backdrop-filter: blur(10px);
        padding: 15px 20px !important;
    }

    .box-title {
        color: var(--mac-text) !important;
        font-weight: 700 !important;
    }

    .user-avatar-sm { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid var(--mac-border); margin-right: 10px; }
    .user-avatar-lg { width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--mac-border); margin: 0 auto 15px auto; display: block; object-fit: cover; }
    
    .status-badge { 
        padding: 4px 12px; 
        border-radius: 50px; 
        font-weight: 700; 
        font-size: 10px; 
        text-transform: uppercase; 
        letter-spacing: 0.5px;
        display: inline-block;
    }
    
    .badge-active { background: rgba(48, 209, 88, 0.15) !important; color: var(--mac-green) !important; border: 1px solid rgba(48, 209, 88, 0.3); }
    .badge-blocked { background: rgba(255, 69, 58, 0.15) !important; color: var(--mac-red) !important; border: 1px solid rgba(255, 69, 58, 0.3); }
    .badge-admin { background: rgba(10, 132, 255, 0.15) !important; color: var(--mac-blue) !important; border: 1px solid rgba(10, 132, 255, 0.3); }
    .badge-user { background: rgba(255, 255, 255, 0.1) !important; color: #fff !important; border: 1px solid rgba(255, 255, 255, 0.2); }

    /* Table Styling */
    .table {
        color: var(--mac-text) !important;
        border-color: var(--mac-border) !important;
    }

    /* Hitam Menyala Header */
    #tblUsers thead tr, #tblUsers thead th {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: var(--mac-border) !important;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .table-hover > tbody > tr:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }

    /* DataTable Controls */
    .dataTables_wrapper .dataTables_filter input {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
        padding: 5px 10px !important;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li > a {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .pagination > li.active > a {
        background: #444446 !important;
        border-color: #444446 !important;
    }

    /* Style for Export Buttons (Excel, PDF, Print) */
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

    /* Modal Styling */
    .modal-content {
        background: #000000 !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 12px !important;
        color: #fff !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.8) !important;
    }

    .modal-header {
        background: #000000 !important;
        border-bottom: 1px solid var(--mac-border) !important;
        padding: 20px 25px !important;
    }

    .modal-body {
        background: #000000 !important;
        padding: 25px !important;
    }

    .modal-footer {
        background: #000000 !important;
        border-top: 1px solid var(--mac-border) !important;
    }

    .form-control {
        background: #1c1c1e !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 8px !important;
        padding: 10px 12px !important;
        height: auto !important;
    }

    .form-control:focus {
        border-color: var(--mac-blue) !important;
        box-shadow: 0 0 0 3px rgba(10, 132, 255, 0.2) !important;
    }

    label {
        color: var(--mac-text-dim) !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        margin-bottom: 8px !important;
    }

    .input-group-addon {
        background: #2c2c2e !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
    }

    hr {
        border-top: 1px solid var(--mac-border) !important;
        margin: 20px 0 !important;
    }

    .text-info { color: var(--mac-blue) !important; }
    .text-muted { color: var(--mac-text-dim) !important; }

    .modal-body {
        background: #000000 !important;
    }

    .modal-footer {
        background: #000000 !important;
        border-top: 1px solid var(--mac-border) !important;
    }

    .form-control {
        background: #1c1c1e !important;
        border: 1px solid var(--mac-border) !important;
        color: #fff !important;
        border-radius: 6px !important;
    }

    label {
        color: var(--mac-text-dim) !important;
        font-weight: 600 !important;
        font-size: 11px;
        text-transform: uppercase;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: var(--mac-bg); }
    ::-webkit-scrollbar-thumb { background: #3a3a3c; border-radius: 10px; }
</style>

<!-- Summary Widgets -->
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number"><?php echo $total_users; ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-green"><i class="fa fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active & Verified</span>
                <span class="info-box-number"><?php echo $active_users; ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-red"><i class="fa fa-lock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Blocked / Locked</span>
                <span class="info-box-number"><?php echo $blocked_users; ?></span>
            </div>
        </div>
    </div>
</div>

<div class="box border-0 shadow-sm">
    <div class="box-header with-border">
        <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-th-list" style="color: var(--mac-blue);"></i> User Directory</h3>
        <div class="box-tools">
            <?php if (isset($can_add_user) && $can_add_user): ?>
            <button class="btn btn-sm btn-flat" style="background: var(--mac-blue); color: #fff; border-radius: 6px;" onclick="showAddModal()"><i class="fa fa-plus"></i> Add New User</button>
            <?php endif; ?>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblUsers" class="table table-hover no-margin" style="font-size:13px; width: 100%;">
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th>User Profile</th>
                        <th>Email & Contact</th>
                        <th>Role & Posisi</th>
                        <th>Account Status</th>
                        <th>Last Activity</th>
                        <th width="120" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($users)): foreach ($users as $i => $u): ?>
                    <tr>
                        <td class="align-middle"><?php echo $i + 1; ?></td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <?php $avatar = !empty($u['avatar']) ? base_url('uploads/avatars/'.$u['avatar']) : base_url('assets/img/default-profile.png'); ?>
                                <img src="<?php echo $avatar; ?>" class="user-avatar-sm pull-left" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo $u['nama']; ?>&background=random'">
                                <div>
                                    <strong><?php echo $u['nama']; ?></strong><br>
                                    <small class="text-muted">@<?php echo $u['username']; ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <i class="fa fa-envelope-o text-muted"></i> <?php echo $u['email']; ?><br>
                            <?php if($u['no_telp']): ?><i class="fa fa-phone text-muted"></i> <?php echo $u['no_telp']; ?><?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <span class="status-badge <?php echo $u['role_id'] == 1 ? 'badge-admin' : 'badge-user'; ?>">
                                <?php echo $u['role_name']; ?>
                            </span>
                            <?php if($u['workzone']): ?>
                                <span class="status-badge" style="background: rgba(255, 255, 255, 0.05); color: var(--mac-text-dim); border: 1px solid var(--mac-border); margin-left: 5px;">G<?php echo $u['workzone']; ?></span>
                            <?php endif; ?>
                            <?php if($u['nama_jabatan']): ?>
                                <br><small class="text-muted"><i class="fa fa-briefcase"></i> <?php echo $u['nama_jabatan']; ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <?php if ($u['is_active']): ?>
                                <span class="status-badge bg-green-active text-white">Active</span>
                            <?php else: ?>
                                <span class="status-badge bg-gray-active text-white">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <?php echo $u['last_login'] ? date('d M Y, H:i', strtotime($u['last_login'])) : '<span class="text-muted">Neverlogged in</span>'; ?>
                        </td>
                        <td class="text-right align-middle btn-action-group">
                            <button class="btn btn-xs btn-flat" style="background: rgba(255,255,255,0.05); border: 1px solid var(--mac-border); color: #fff;" title="Edit Profile" onclick="editUser(<?php echo $u['id']; ?>)"><i class="fa fa-pencil text-warning"></i></button>
                            <button class="btn btn-xs btn-flat" style="background: rgba(255,255,255,0.05); border: 1px solid var(--mac-border); color: #fff;" title="Reset Password" onclick="resetPwd(<?php echo $u['id']; ?>)"><i class="fa fa-key text-warning"></i></button>
                            <button class="btn btn-xs btn-flat" style="background: rgba(255,255,255,0.05); border: 1px solid var(--mac-border); color: #fff;" title="<?php echo $u['is_blocked'] ? 'Unlock Account' : 'Block Account'; ?>" onclick="toggleBlock(<?php echo $u['id']; ?>)">
                                <i class="fa fa-<?php echo $u['is_blocked'] ? 'unlock text-success' : 'ban text-danger'; ?>"></i>
                            </button>
                            <button class="btn btn-xs btn-flat" style="background: rgba(255,255,255,0.05); border: 1px solid var(--mac-border); color: #fff;" title="Delete Account" onclick="deleteUser(<?php echo $u['id']; ?>)"><i class="fa fa-trash text-red"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal User -->
<div class="modal fade" id="modalUser">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header shadow-sm" style="border:0; background: #000000 !important; color: #ffffff !important;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity: 1;">&times;</button>
                <h4 class="modal-title" style="color:#fff; font-weight: 700;" id="modalTitle">User Account</h4>
            </div>
            <form id="formUser" enctype="multipart/form-data">
                <input type="hidden" name="id" id="userId">
                <div class="modal-body">
                    
                    <div class="text-center">
                        <img id="imgAvatarPreview" src="https://ui-avatars.com/api/?name=User&background=random" class="user-avatar-lg">
                        <input type="file" name="avatar" id="inputAvatar" class="hidden" accept="image/*">
                        <button type="button" class="btn btn-flat" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--mac-border); border-radius: 6px; padding: 5px 15px; font-size: 11px;" onclick="$('#inputAvatar').click()"><i class="fa fa-camera"></i> Change Avatar</button>
                    </div>
                    
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="e.g. admin" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="John Doe" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="0812xxxx">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password <small class="text-info pul-right" id="pwdHint">(required)</small></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                            <span class="input-group-addon" style="cursor: pointer;" onclick="togglePwd()"><i class="fa fa-eye" id="pwdIcon"></i></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Assigned Role (Hak Akses)</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    <option value="">— Pilih Role Akses —</option>
                                    <?php if (isset($roles)): foreach ($roles as $r): ?>
                                    <option value="<?php echo $r['id']; ?>"><?php echo $r['role_name']; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan Organisasi (Opsional)</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-control">
                                    <option value="">— Pilih Jabatan —</option>
                                    <?php if (isset($jabatan)): foreach ($jabatan as $j): ?>
                                    <option value="<?php echo $j['id']; ?>"><?php echo $j['nama_jabatan']; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Workzone Assignment</label>
                                <select name="workzone" id="workzone" class="form-control">
                                    <option value="">— Group (Superadmin) —</option>
                                    <option value="1">Group 1 (TRK, TAJ, JWT)</option>
                                    <option value="2">Group 2 (MLN, TPE, NNK, SNY)</option>
                                    <option value="3">Group 3 (TRD, TBY, LNN, TSL, TLA)</option>
                                    <option value="4">Group 4 (MLN, TPE)</option>
                                    <option value="5">Group 5 (NNK, SNY)</option>
                                    <option value="6">Group 6 (TSL, TLA)</option>
                                    <option value="7">Group 7 (TRD, TBY, LNN)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="statusGroup">
                            <div class="form-group">
                                <label>Account Status</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1">Active / Verified</option>
                                    <option value="0">Deactivated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0" style="background: #000000 !important; padding: 20px;">
                    <button type="button" class="btn btn-flat" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--mac-border); border-radius: 8px; padding: 8px 20px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-flat" style="background: var(--mac-blue); color: #fff; border-radius: 8px; padding: 8px 25px; font-weight: 700;" id="btnSave"><i class="fa fa-save"></i> Save Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#tblUsers').DataTable({
        autoWidth: false
    });

    // Avatar preview
    $('#inputAvatar').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgAvatarPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});

var isEdit = false;
function showAddModal(){
    isEdit = false;
    $('#modalTitle').text('Register New Account');
    $('#formUser')[0].reset();
    $('#userId').val('');
    $('#username').prop('readonly', false);
    $('#password').prop('required', true);
    $('#role_id').val('');
    $('#jabatan_id').val('');
    $('#pwdHint').text('(required)').attr('class', 'text-info');
    $('#statusGroup').hide();
    $('#imgAvatarPreview').attr('src', 'https://ui-avatars.com/api/?name=User&background=random');
    $('#modalUser').modal('show');
}

function editUser(id){
    isEdit = true;
    $.post(BASE_URL + 'admin/users/get_user', {id: id}, function(res){
        var u = JSON.parse(res);
        $('#modalTitle').text('Edit Account Profile');
        $('#userId').val(u.id);
        $('#username').val(u.username).prop('readonly', true);
        $('#nama').val(u.nama);
        $('#email').val(u.email);
        $('#no_telp').val(u.no_telp);
        $('#password').val('').prop('required', false);
        $('#pwdHint').text('(leave blank to keep current password)').attr('class', 'text-warning');
        $('#role_id').val(u.role_id);
        $('#jabatan_id').val(u.jabatan_id);
        $('#workzone').val(u.workzone);
        $('#is_active').val(u.is_active);
        
        var avatarUrl = u.avatar ? BASE_URL + 'uploads/avatars/' + u.avatar : 'https://ui-avatars.com/api/?name=' + encodeURI(u.nama) + '&background=random';
        $('#imgAvatarPreview').attr('src', avatarUrl);
        
        $('#statusGroup').show();
        $('#modalUser').modal('show');
    });
}

$('#formUser').submit(function(e){
    e.preventDefault();
    var url = isEdit ? BASE_URL + 'admin/users/update' : BASE_URL + 'admin/users/add';
    var formData = new FormData(this);
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){
            var r = JSON.parse(res);
            if (r.status == 'success') {
                $('#modalUser').modal('hide');
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        }
    });
});

function togglePwd() {
    var x = document.getElementById("password");
    var i = document.getElementById("pwdIcon");
    if (x.type === "password") {
        x.type = "text";
        i.className = "fa fa-eye-slash";
    } else {
        x.type = "password";
        i.className = "fa fa-eye";
    }
}

function deleteUser(id){
    App.confirm('Deactivate User?', 'This account will be moved to Recycle Bin logic.', function(){
        $.post(BASE_URL+'admin/users/delete',{id:id},function(res){
            var r=JSON.parse(res);
            if(r.status=='success'){
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    });
}

function toggleBlock(id){
    $.post(BASE_URL+'admin/users/toggle_block',{id:id},function(res){
        var r=JSON.parse(res);
        if(r.status=='success'){
            App.toast(r.message, 'success');
            setTimeout(function(){ location.reload(); }, 1000);
        } else {
            App.alert('Error', r.message, 'error');
        }
    });
}

function resetPwd(id){
    Swal.fire({
        title: 'Force Password Reset',
        text: 'Set a new password for this user immediately.',
        input: 'password',
        inputPlaceholder: 'Type new password...',
        showCancelButton: true,
        confirmButtonColor: '#0A84FF',
        confirmButtonText: 'Update Now!',
        cancelButtonText: 'Cancel',
        background: '#1c1c1e',
        color: '#fff'
    }).then(function(result){
        if(result.value){
            $.post(BASE_URL+'admin/users/reset_password', {id:id, new_password:result.value}, function(res){
                var r=JSON.parse(res);
                if(r.status=='success'){
                    App.toast(r.message, 'success');
                } else {
                    App.alert('Error', r.message, 'error');
                }
            });
        }
    });
}
</script>
