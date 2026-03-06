<style>
    .profile-wrapper { display: flex; gap: 30px; align-items: flex-start; }
    .profile-side { width: 330px; flex-shrink: 0; }
    .profile-content { flex-grow: 1; }

    /* Utilities */
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    .shadow-xs { box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05); }

    /* Summary Card */
    .card-summary { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 40px 30px; text-align: center; }
    .avatar-wrapper { position: relative; width: 130px; height: 130px; margin: 0 auto 25px; }
    .avatar-img { width: 130px; height: 130px; border-radius: 40px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
    .avatar-upload-btn { 
        position: absolute; bottom: -5px; right: -5px; width: 40px; height: 40px; 
        background: #4f46e5; color: #fff; border-radius: 14px; border: 3px solid #fff;
        display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }
    .avatar-upload-btn:hover { background: #4338ca; transform: translateY(-2px); }

    .summary-name { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 5px 0; letter-spacing: -0.5px; }
    .summary-role { color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 30px; }
    
    .summary-info-list { list-style: none; padding: 0; margin: 0; text-align: left; }
    .summary-info-list li { display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
    .summary-info-list li:last-child { border-bottom: none; }
    .summary-info-list li span:first-child { color: #94a3b8; font-weight: 600; }
    .summary-info-list li span:last-child { color: #1e293b; font-weight: 700; }

    /* Settings Card */
    .card-settings { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; }
    .profile-nav { background: #f8fafc; border-bottom: 1px solid #f1f5f9; display: flex; padding: 0; margin: 0; }
    .profile-nav li { list-style: none; }
    .profile-nav li a { 
        display: block; padding: 20px 35px; color: #64748b; font-weight: 700; font-size: 13px; 
        text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 3px solid transparent; 
        transition: all 0.2s; border-radius: 0; margin-right: 0; border: none;
        border-bottom: 3px solid transparent;
    }
    .profile-nav li.active a, .profile-nav li.active a:hover, .profile-nav li.active a:focus { 
        color: #4f46e5 !important; border: none !important; border-bottom: 3px solid #4f46e5 !important; background: #fff !important; 
    }
    .profile-nav li a:hover { background: #f1f5f9; color: #1e293b; border-bottom-color: #cbd5e1; }

    .setting-pane { padding: 45px; }
    .form-label { display: block; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px; }
    .profile-input { 
        width: 100%; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0; 
        font-size: 14px; color: #1e293b; transition: all 0.2s; background: #fcfcfc;
    }
    .profile-input:focus { border-color: #4f46e5; background: #fff; outline: none; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08); }

    .btn-save { 
        background: #4f46e5; color: #fff; border: none; padding: 15px 35px; border-radius: 12px; 
        font-weight: 800; font-size: 14px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }
    .btn-save:hover:not(:disabled) { background: #4338ca; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(79, 70, 229, 0.35); }
    .btn-save:disabled { opacity: 0.7; cursor: not-allowed; }

    .pwd-wrapper { position: relative; }
    .pwd-toggle { position: absolute; right: 18px; top: 16px; color: #94a3b8; cursor: pointer; transition: color 0.2s; }
    .pwd-toggle:hover { color: #4f46e5; }
</style>

<div class="profile-wrapper">
    <!-- Sidebar Summary -->
    <div class="profile-side">
        <div class="card-summary shadow-md">
            <?php 
                $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($user['nama']) . "&size=128&background=4f46e5&color=fff&bold=true";
                if ($user['avatar'] && $user['avatar'] != 'default.png' && file_exists(FCPATH . 'uploads/avatars/' . $user['avatar'])) {
                    $avatar_url = base_url('uploads/avatars/' . $user['avatar']);
                }
            ?>
            <div class="avatar-wrapper">
                <img id="profile-img" class="avatar-img" src="<?php echo $avatar_url; ?>" alt="Profile">
                <div class="avatar-upload-btn" id="btn-change-avatar" title="Update Identity Avatar">
                    <i class="fa fa-camera"></i>
                </div>
                <form id="formAvatar" style="display:none;">
                    <input type="file" name="avatar" id="input-avatar" accept="image/*">
                </form>
            </div>

            <h3 class="summary-name"><?php echo $user['nama']; ?></h3>
            <span class="summary-role"><?php echo str_replace('_', ' ', $user['role_name']); ?></span>

            <ul class="summary-info-list">
                <li><span>Username</span> <span>@<?php echo $user['username']; ?></span></li>
                <li><span>User Core ID</span> <span class="badge" style="color:#4f46e5; background:#eef2ff; border:none; padding:5px 12px; font-weight:800;">UID-<?php echo str_pad($user['id'], 5, '0', STR_PAD_LEFT); ?></span></li>
                <li><span>Member Since</span> <span><?php echo date('M d, Y', strtotime($user['created_at'])); ?></span></li>
            </ul>
        </div>

        <div class="alert shadow-xs" style="margin-top: 25px; border-radius: 16px; background: #fff; border: 1px solid #e2e8f0; color: #64748b;">
            <p class="small no-margin"><i class="fa fa-shield text-indigo"></i> <strong>Identity Guard:</strong> Your unique core ID and avatar are used to certify all database transactions and system interactions.</p>
        </div>
    </div>

    <!-- Content Area -->
    <div class="profile-content">
        <div class="card-settings shadow-md">
            <ul class="profile-nav nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab">General Profile</a></li>
                <li><a href="#security" data-toggle="tab">Access & Security</a></li>
            </ul>

            <div class="tab-content">
                <!-- General Tab -->
                <div class="tab-pane active" id="general">
                    <div class="setting-pane">
                        <form id="formProfile">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label class="form-label">Active Representative Name</label>
                                        <input type="text" name="nama" class="profile-input" value="<?php echo $user['nama']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label class="form-label">System Handle (Username)</label>
                                        <input type="text" name="username" class="profile-input" value="<?php echo $user['username']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="margin-top: 20px; padding-top: 30px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn-save">
                                    <i class="fa fa-refresh"></i> SYNC PROFILE IDENTITY
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div class="tab-pane" id="security">
                    <div class="setting-pane">
                        <form id="formPassword">
                            <div class="form-group mb-30">
                                <label class="form-label">Current Access Pin (Password)</label>
                                <div class="pwd-wrapper">
                                    <input type="password" name="old_password" class="profile-input pwd-input" placeholder="Verify your current identity..." required>
                                    <i class="fa fa-eye-slash pwd-toggle"></i>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label class="form-label">New Master Key</label>
                                        <div class="pwd-wrapper">
                                            <input type="password" name="new_password" class="profile-input pwd-input" required>
                                            <i class="fa fa-eye-slash pwd-toggle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label class="form-label">Re-verify New Key</label>
                                        <div class="pwd-wrapper">
                                            <input type="password" name="confirm_password" class="profile-input pwd-input" required>
                                            <i class="fa fa-eye-slash pwd-toggle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 20px; padding-top: 30px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn-save">
                                    <i class="fa fa-lock"></i> ROTATE SECURITY KEYS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    // --- 2. Identity Synchronization ---
    $('#formProfile').submit(function(e) {
        e.preventDefault();
        var btn = $(this).find('button[type="submit"]');
        var original = btn.html();
        
        btn.prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> SYNCING...');
        
        $.post(BASE_URL + 'admin/profile/update', $(this).serialize(), function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.toast(r.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                btn.prop('disabled', false).html(original);
                App.alert('Access Refused', r.message, 'error');
            }
        }).fail(function() {
            btn.prop('disabled', false).html(original);
            App.alert('Critical Fault', 'Failed to reach identity server.', 'error');
        });
    });

    // --- 3. Security Credentials Rotation ---
    $('#formPassword').submit(function(e) {
        e.preventDefault();
        var btn = $(this).find('button[type="submit"]');
        var original = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> ROTATING KEYS...');
        
        $.post(BASE_URL + 'admin/profile/update_password', $(this).serialize(), function(res) {
            var r = JSON.parse(res);
            if (r.status == 'success') {
                App.alert('Success', r.message, 'success').then(() => {
                    $('#formPassword')[0].reset();
                    btn.prop('disabled', false).html(original);
                });
            } else {
                btn.prop('disabled', false).html(original);
                App.alert('Rotation Failed', r.message, 'error');
            }
        }).fail(function() {
            btn.prop('disabled', false).html(original);
            App.alert('Critical Fault', 'Security infrastructure is unreachable.', 'error');
        });
    });

    // --- 4. Visual Visibility Toggle ---
    $('.pwd-toggle').click(function() {
        var input = $(this).siblings('.pwd-input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    // --- 5. Avatar Data Stream ---
    $('#btn-change-avatar').click(() => $('#input-avatar').click());
    $('#input-avatar').change(function() {
        var formData = new FormData($('#formAvatar')[0]);
        var btn = $('#btn-change-avatar');
        
        btn.html('<i class="fa fa-refresh fa-spin"></i>').css('opacity', '0.7');
        App.toast('Streaming binary data...', 'info');
        
        $.ajax({
            url: BASE_URL + 'admin/profile/update_avatar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                var r = JSON.parse(res);
                if (r.status == 'success') {
                    App.toast('Identity visual updated.', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    btn.html('<i class="fa fa-camera"></i>').css('opacity', '1');
                    App.alert('Stream Refused', r.message, 'error');
                }
            },
            error: function() {
                btn.html('<i class="fa fa-camera"></i>').css('opacity', '1');
                App.toast('Fault during data transmission.', 'error');
            }
        });
    });
});
</script>
