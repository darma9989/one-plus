<style>
    .settings-wrapper { display: flex; gap: 30px; }
    .settings-sidebar { width: 280px; flex-shrink: 0; }
    .settings-content-area { flex-grow: 1; }

    .nav-settings { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; padding: 10px 0; }
    .nav-settings li { padding: 2px 10px; }
    .nav-settings li a { 
        display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; 
        color: #64748b; font-weight: 500; transition: all 0.2s;
    }
    .nav-settings li a i { width: 20px; font-size: 16px; margin-right: 12px; }
    .nav-settings li.active a { background: #eff6ff; color: #3b82f6; font-weight: 700; }
    .nav-settings li a:hover:not(.active) { background: #f8fafc; color: #1e293b; padding-left: 20px; }

    .settings-panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 500px; display: flex; flex-direction: column; }
    .settings-panel-header { padding: 25px 30px; border-bottom: 1px solid #f1f5f9; }
    .settings-panel-header h4 { margin: 0; font-weight: 800; color: #1e293b; letter-spacing: -0.5px; }
    .settings-panel-header p { margin: 5px 0 0 0; color: #64748b; font-size: 13px; }
    .settings-panel-body { padding: 30px; flex-grow: 1; }
    .settings-panel-footer { padding: 20px 30px; background: #f8fafc; border-top: 1px solid #f1f5f9; border-radius: 0 0 12px 12px; text-align: right; }

    .logo-upload-zone { border: 2px dashed #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; transition: all 0.2s; background: #f8fafc; cursor: pointer; position: relative; }
    .logo-upload-zone:hover { border-color: #3b82f6; background: #fff; }
    .logo-current-preview { max-width: 150px; max-height: 80px; margin: 0 auto 15px auto; display: flex; align-items: center; justify-content: center; }
    .logo-current-preview img { max-width: 100%; border-radius: 4px; }

    /* Layout Selection */
    .layout-picker { display: flex; gap: 20px; margin-top: 10px; }
    .layout-option { flex: 1; border: 2px solid #f1f5f9; border-radius: 12px; padding: 15px; cursor: pointer; transition: all 0.2s; position: relative; }
    .layout-option:hover { border-color: #e2e8f0; }
    .layout-option.active { border-color: #3b82f6; background: #eff6ff; }
    .layout-option .mock-ui { background: #e2e8f0; height: 60px; border-radius: 4px; margin-bottom: 10px; display: flex; }
    .layout-option .mock-sidebar { width: 20px; background: #cbd5e1; border-radius: 4px 0 0 4px; }
    .layout-option .mock-topnav { height: 12px; background: #cbd5e1; border-radius: 4px 4px 0 0; width: 100%; }
    .layout-option strong { display: block; font-size: 13px; color: #1e293b; text-align: center; }

    .skin-dot { width: 32px; height: 32px; border-radius: 50%; display: inline-block; margin-right: 10px; cursor: pointer; border: 3px solid #fff; box-shadow: 0 0 0 1px #e2e8f0; transition: all 0.2s; }
    .skin-dot.active { transform: scale(1.2); box-shadow: 0 0 0 2px #3b82f6; }

    .form-section-title { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin: 30px 0 15px 0; display: flex; align-items: center; gap: 10px; }
    .form-section-title::after { content: ''; flex-grow: 1; height: 1px; background: #f1f5f9; }
</style>

<div class="settings-wrapper">
    <!-- Navigation Sidebar -->
    <div class="settings-sidebar">
        <div class="nav-settings shadow-sm">
            <div style="padding: 15px 25px; border-bottom: 1px solid #f1f5f9; margin-bottom: 10px;">
                <span class="text-muted small font-bold" style="text-transform: uppercase; letter-spacing: 0.5px;">Settings Engine</span>
            </div>
            <ul class="nav">
                <li class="active">
                    <a href="#general" data-toggle="pill"><i class="fa fa-sliders"></i> Application Brand</a>
                </li>
                <li>
                    <a href="#appearance" data-toggle="pill"><i class="fa fa-magic"></i> User Experience</a>
                </li>
                <li>
                    <a href="#security" data-toggle="pill"><i class="fa fa-lock"></i> Protocol & Security</a>
                </li>
                <li>
                    <a href="#system" data-toggle="pill"><i class="fa fa-cogs"></i> Infrastructure</a>
                </li>
            </ul>
        </div>

        <div class="alert alert-info border-0 shadow-sm" style="margin-top: 25px; border-radius: 12px; background: #f0f9ff; color: #0369a1;">
            <p class="small no-margin"><i class="fa fa-info-circle"></i> These settings define global application behavior. Be cautious when adjusting infrastructure paths.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="settings-content-area">
        <form id="formSettings" enctype="multipart/form-data">
            <div class="tab-content no-padding">
                
                <!-- ENTITY BRANDING -->
                <div class="tab-pane active" id="general">
                    <div class="settings-panel shadow-sm">
                        <div class="settings-panel-header">
                            <h4><i class="fa fa-rocket text-primary"></i> <span class="active-tab-label">Application Entity</span></h4>
                            <p>Define the identity and signature of your enterprise portal.</p>
                        </div>
                        <div class="settings-panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="text-muted small font-bold">APPLICATION TITLE</label>
                                        <input type="text" name="app_name" class="form-control btn-flat" value="<?php echo isset($all_settings['app_name']) ? htmlspecialchars($all_settings['app_name']) : ''; ?>" placeholder="Enter official name">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted small font-bold">VERSIONING TAG</label>
                                        <input type="text" name="app_version" class="form-control btn-flat" value="<?php echo isset($all_settings['app_version']) ? htmlspecialchars($all_settings['app_version']) : ''; ?>" placeholder="v1.0.0">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="text-muted small font-bold">IDENTITY LOGO</label>
                                    <div class="logo-upload-zone" onclick="$('#inputLogo').click()">
                                        <div class="logo-current-preview">
                                            <?php 
                                            $logo = 'https://via.placeholder.com/150x80?text=No+Brand';
                                            if (!empty($all_settings['app_logo']) && file_exists(FCPATH . 'uploads/settings/' . $all_settings['app_logo'])) {
                                                $logo = base_url('uploads/settings/'.$all_settings['app_logo']);
                                            }
                                            ?>
                                            <img src="<?php echo $logo; ?>" id="imgLogoPreview">
                                        </div>
                                        <span class="text-blue small font-bold"><i class="fa fa-cloud-upload"></i> Upload New Media</span>
                                    </div>
                                    <input type="file" name="app_logo" id="inputLogo" style="display:none;" accept="image/*">
                                </div>
                            </div>

                            <div class="form-section-title">Legal & Content</div>
                            
                            <div class="form-group">
                                <label class="text-muted small font-bold">PORTAL SLOGAN / DESCRIPTION</label>
                                <textarea name="app_description" class="form-control btn-flat" rows="3"><?php echo isset($all_settings['app_description']) ? htmlspecialchars($all_settings['app_description']) : ''; ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="text-muted small font-bold">FOOTER ATTRIBUTION</label>
                                <input type="text" name="footer_text" class="form-control btn-flat" value="<?php echo isset($all_settings['footer_text']) ? htmlspecialchars($all_settings['footer_text']) : ''; ?>" placeholder="© 2024 Enterprise Hub">
                            </div>
                        </div>
                        <div class="settings-panel-footer">
                            <button type="submit" class="btn btn-primary btn-flat" style="padding: 10px 30px; font-weight: 700;">COMMIT CHANGES</button>
                        </div>
                    </div>
                </div>

                <!-- APPEARANCE -->
                <div class="tab-pane" id="appearance">
                    <div class="settings-panel shadow-sm">
                        <div class="settings-panel-header">
                            <h4><i class="fa fa-image text-green"></i> <span class="active-tab-label">Interface Experience</span></h4>
                            <p>Configure layouts and theme palettes for the workspace.</p>
                        </div>
                        <div class="settings-panel-body">
                            <label class="text-muted small font-bold">CORE NAVIGATION ARCHITECTURE</label>
                            <div class="layout-picker">
                                <div class="layout-option <?php echo (!isset($all_settings['sidebar_layout']) || $all_settings['sidebar_layout'] == 'sidebar') ? 'active' : ''; ?>" onclick="selectLayout(this, 'sidebar')">
                                    <div class="mock-ui">
                                        <div class="mock-sidebar"></div>
                                        <div style="flex-grow:1; padding: 10px;"><div style="height:4px; background:#f1f5f9; width:40%;"></div></div>
                                    </div>
                                    <strong>Sidebar Modern</strong>
                                </div>
                                <div class="layout-option <?php echo (isset($all_settings['sidebar_layout']) && $all_settings['sidebar_layout'] == 'topnav') ? 'active' : ''; ?>" onclick="selectLayout(this, 'topnav')">
                                    <div class="mock-ui" style="display:block;">
                                        <div class="mock-topnav"></div>
                                        <div style="padding: 10px;"><div style="height:4px; background:#f1f5f9; width:40%;"></div></div>
                                    </div>
                                    <strong>Top Navigation</strong>
                                </div>
                                <input type="hidden" name="sidebar_layout" id="inputLayout" value="<?php echo isset($all_settings['sidebar_layout']) ? $all_settings['sidebar_layout'] : 'sidebar'; ?>">
                            </div>

                            <div class="form-section-title">Color Palette</div>

                            <div class="form-group">
                                <label class="text-muted small font-bold">SYSTEM SKIN ACCENT</label>
                                <div style="margin-top: 10px;">
                                    <?php 
                                    $skins = array('blue' => '#3c8dbc', 'green' => '#00a65a', 'red' => '#dd4b39', 'yellow' => '#f39c12', 'purple' => '#605ca8', 'black' => '#111'); 
                                    foreach ($skins as $key => $color): 
                                        $isActive = (isset($all_settings['skin_color']) && $all_settings['skin_color'] == $key) ? 'active' : '';
                                    ?>
                                    <div class="skin-dot <?php echo $isActive; ?>" data-skin="<?php echo $key; ?>" style="background: <?php echo $color; ?>" title="<?php echo ucfirst($key); ?>" onclick="selectSkin(this, '<?php echo $key; ?>')"></div>
                                    <?php endforeach; ?>
                                    <input type="hidden" name="skin_color" id="inputSkin" value="<?php echo isset($all_settings['skin_color']) ? $all_settings['skin_color'] : 'blue'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="settings-panel-footer">
                            <button type="submit" class="btn btn-primary btn-flat" style="padding: 10px 30px; font-weight: 700;">COMMIT CHANGES</button>
                        </div>
                    </div>
                </div>

                <!-- SECURITY -->
                <div class="tab-pane" id="security">
                    <div class="settings-panel shadow-sm">
                        <div class="settings-panel-header">
                            <h4><i class="fa fa-shield text-orange"></i> <span class="active-tab-label">Access Governance</span></h4>
                            <p>Protocols for session handling and brute-force prevention.</p>
                        </div>
                        <div class="settings-panel-body">
                            <div class="form-group">
                                <label class="text-muted small font-bold">BRUTE-FORCE THRESHOLD</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="number" name="login_attempts" class="form-control btn-flat" value="<?php echo isset($all_settings['login_attempts']) ? $all_settings['login_attempts'] : 3; ?>" min="1" max="10">
                                            <span class="input-group-addon bg-gray-light">MAX ATTEMPTS</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="help-block small italic mt-10">System will invalidate access for the identity after reaching this threshold.</p>
                            </div>
                        </div>
                        <div class="settings-panel-footer">
                            <button type="submit" class="btn btn-primary btn-flat" style="padding: 10px 30px; font-weight: 700;">COMMIT CHANGES</button>
                        </div>
                    </div>
                </div>

                <!-- SYSTEM -->
                <div class="tab-pane" id="system">
                    <div class="settings-panel shadow-sm">
                        <div class="settings-panel-header">
                            <h4><i class="fa fa-server text-muted"></i> <span class="active-tab-label">Logical Foundation</span></h4>
                            <p>Internal infrastructure definitions and system nodes.</p>
                        </div>
                        <div class="settings-panel-body">
                            <div class="form-group">
                                <label class="text-muted small font-bold">DATABASE BACKUP ENDPOINT</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-folder-open"></i></span>
                                    <input type="text" name="backup_path" class="form-control btn-flat" value="<?php echo isset($all_settings['backup_path']) ? htmlspecialchars($all_settings['backup_path']) : './uploads/backups/'; ?>">
                                </div>
                                <p class="help-block small"><i class="fa fa-warning text-orange"></i> Ensure local storage permission is set to <strong>0777 (Writable)</strong>.</p>
                            </div>

                            <div class="form-section-title">Maintenance & Lifecycle</div>
                            
                            <div class="form-group">
                                <label class="text-muted small font-bold">SYSTEM MAINTENANCE OVERRIDE</label>
                                <div style="display: flex; align-items: center; gap: 15px; background: #fff8f1; padding: 15px; border-radius: 10px; border: 1px solid #ffedd5;">
                                    <div class="switch-container">
                                        <select name="maintenance_mode" class="form-control btn-flat border-orange shadow-none" style="width: 120px;">
                                            <option value="0" <?php echo (isset($all_settings['maintenance_mode']) && $all_settings['maintenance_mode'] == '0') ? 'selected' : ''; ?>>DISABLED</option>
                                            <option value="1" <?php echo (isset($all_settings['maintenance_mode']) && $all_settings['maintenance_mode'] == '1') ? 'selected' : ''; ?>>ENABLED</option>
                                        </select>
                                    </div>
                                    <div style="font-size: 13px; color: #9a3412;">
                                        <strong>When enabled</strong>, only Super Admins can access the system. Other users will be redirected to the maintenance alert.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="text-muted small font-bold">MAINTENANCE ALERT MESSAGE</label>
                                <textarea name="maintenance_message" class="form-control btn-flat" rows="3" placeholder="Sistem sedang pemeliharaan..."><?php echo isset($all_settings['maintenance_message']) ? htmlspecialchars($all_settings['maintenance_message']) : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="settings-panel-footer">
                            <button type="submit" class="btn btn-primary btn-flat" style="padding: 10px 30px; font-weight: 700;">COMMIT CHANGES</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
$(function(){
    // --- 1. Tab Persistence & Flow ---
    function syncTab() {
        var hash = window.location.hash || '#general';
        $('.nav-settings li').removeClass('active');
        $('.nav-settings a[href="' + hash + '"]').parent().addClass('active');
        $('.tab-pane').removeClass('active');
        $(hash).addClass('active');
        
        // Dynamic Title Sync
        var tabTitle = $('.nav-settings a[href="' + hash + '"]').text().trim();
        $('.active-tab-label').text(tabTitle);
    }

    $('.nav-settings a').click(function(e) {
        e.preventDefault();
        var hash = $(this).attr('href');
        window.location.hash = hash;
        syncTab();
    });

    // Run on load
    syncTab();

    // --- 2. Live Preview Engine ---
    window.selectLayout = function(el, val) {
        $('.layout-option').removeClass('active');
        $(el).addClass('active');
        $('#inputLayout').val(val);
        
        // Live UX Update
        if(val === 'topnav') {
            $('body').addClass('layout-top-nav');
        } else {
            $('body').removeClass('layout-top-nav');
        }
        App.toast('Preview: Layout changed to ' + val, 'info');
    };

    window.selectSkin = function(el, val) {
        $('.skin-dot').removeClass('active');
        $(el).addClass('active');
        $('#inputSkin').val(val);
        
        // Live Color Update
        var body = $('body');
        var classes = body.attr('class').split(' ');
        classes.forEach(function(c) {
            if(c.startsWith('skin-')) body.removeClass(c);
        });
        body.addClass('skin-' + val);
        App.toast('Preview: Accent set to ' + val, 'info');
    };

    // --- 3. Logo Preview ---
    $('#inputLogo').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imgLogoPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // --- 4. Synchronized Global Save ---
    $('#formSettings').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.html();
        
        App.confirm('Execute System Synchronization?', 'New architecture and brand parameters will be applied globally.', function() {
            btn.prop('disabled', true).html('<i class="fa fa-refresh fa-spin"></i> SYNCING...');
            
            $.ajax({
                url: BASE_URL + 'admin/settings/save',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    var r = JSON.parse(res);
                    if(r.status == 'success') {
                        App.toast(r.message, 'success');
                        setTimeout(function() { location.reload(); }, 1000);
                    } else {
                        btn.prop('disabled', false).html(originalText);
                        App.alert('Sync Refused', r.message, 'error');
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html(originalText);
                    App.alert('Critical Error', 'Network or server node failure.', 'error');
                }
            });
        }, 'info');
    });
});
</script>

