<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($sys_app_name) ? $sys_app_name : 'Starter Kit'; ?> | <?php echo isset($title) ? $title : ''; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/font-awesome.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/buttons.bootstrap.min.css'); ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/sweetalert2.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/AdminLTE.min.css'); ?>">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/_all-skins.min.css'); ?>">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Custom -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/custom.css'); ?>">
    
    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets/starter_kit/vendor/jquery-3.6.0.min.js'); ?>"></script>
    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
        var CSRF_NAME = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var CSRF_HASH = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
</head>
<?php
    $skin = isset($sys_skin_color) ? $sys_skin_color : 'blue';
    $layout_class = (isset($sidebar_layout) && $sidebar_layout == 'topnav') ? 'layout-top-nav' : '';
?>
<body class="hold-transition skin-<?php echo $skin; ?> sidebar-mini <?php echo $layout_class; ?>">
<div class="wrapper">

    <?php if (isset($sidebar_layout) && $sidebar_layout == 'topnav'): ?>
    <!-- ===== TOP NAVIGATION LAYOUT ===== -->
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="<?php echo base_url('dashboard'); ?>" class="navbar-brand">
                        <?php if (!empty($sys_app_logo) && file_exists(FCPATH . 'uploads/settings/' . $sys_app_logo)): ?>
                            <img src="<?php echo base_url('uploads/settings/' . $sys_app_logo); ?>" alt="Logo" style="max-height: 30px; margin-top: -5px;">
                        <?php else: ?>
                            <b><?php echo isset($sys_app_name) ? $sys_app_name : 'Starter Kit'; ?></b>
                        <?php endif; ?>
                    </a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php if (isset($menu) && is_array($menu)): ?>
                        <?php foreach ($menu as $m): ?>
                            <?php 
                                $is_active = ($current_uri == $m['menu_link']);
                                $has_active_child = false;
                                if (isset($m['children'])) {
                                    foreach ($m['children'] as $child) {
                                        if ($current_uri == $child['menu_link']) $has_active_child = true;
                                    }
                                }
                            ?>
                            <?php if (isset($m['children']) && !empty($m['children'])): ?>
                            <li class="dropdown <?php echo ($is_active || $has_active_child) ? 'active' : ''; ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="<?php echo $m['menu_icon']; ?>"></i> <?php echo $m['menu_name']; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($m['children'] as $child): ?>
                                    <li class="<?php echo ($current_uri == $child['menu_link']) ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url($child['menu_link']); ?>">
                                            <i class="<?php echo $child['menu_icon']; ?>"></i> <?php echo $child['menu_name']; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <?php else: ?>
                            <li class="<?php echo $is_active ? 'active' : ''; ?>">
                                <a href="<?php echo base_url($m['menu_link']); ?>"><i class="<?php echo $m['menu_icon']; ?>"></i> <?php echo $m['menu_name']; ?></a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php 
                            $user_avatar = "https://ui-avatars.com/api/?name=" . urlencode($current_user['nama']) . "&background=random&color=fff";
                            if (isset($current_user['avatar']) && $current_user['avatar'] != 'default.png' && file_exists('./uploads/avatars/' . $current_user['avatar'])) {
                                $user_avatar = base_url('uploads/avatars/' . $current_user['avatar']);
                            }
                        ?>
                        <li class="user user-menu">
                            <a href="<?php echo base_url('admin/profile'); ?>" title="My Profile Settings" style="background: rgba(0,0,0,0.05); border-radius: 30px; margin: 8px 10px; padding: 5px 15px 5px 5px; display: flex; align-items: center; transition: background 0.2s;">
                                <img src="<?php echo $user_avatar; ?>" class="user-image" alt="User Image" style="margin-right: 10px;">
                                <span class="hidden-xs" style="font-weight: 600;"><?php echo isset($current_user) ? $current_user['nama'] : ''; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="App.confirm('Sign Out?', 'Are you sure you want to end your secure session?', function(){ window.location.href='<?php echo base_url('auth/logout'); ?>'; });" title="Secure Logout" style="color: #ef4444;">
                                <i class="fa fa-power-off"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php else: ?>
    <!-- ===== SIDEBAR LAYOUT ===== -->
    <header class="main-header">
        <a href="<?php echo base_url('dashboard'); ?>" class="logo">
            <span class="logo-mini"><b>SK</b></span>
            <span class="logo-lg">
                <?php if (!empty($sys_app_logo) && file_exists(FCPATH . 'uploads/settings/' . $sys_app_logo)): ?>
                    <img src="<?php echo base_url('uploads/settings/' . $sys_app_logo); ?>" alt="Logo" style="max-height: 40px;">
                <?php else: ?>
                    <b><?php echo isset($sys_app_name) ? $sys_app_name : 'Starter Kit'; ?></b>
                <?php endif; ?>
            </span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle</span></a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php 
                        $user_avatar = "https://ui-avatars.com/api/?name=" . urlencode($current_user['nama']) . "&background=random&color=fff";
                        if (isset($current_user['avatar']) && $current_user['avatar'] != 'default.png' && file_exists('./uploads/avatars/' . $current_user['avatar'])) {
                            $user_avatar = base_url('uploads/avatars/' . $current_user['avatar']);
                        }
                    ?>
                    <li class="user user-menu">
                        <a href="<?php echo base_url('admin/profile'); ?>" title="My Profile Settings" style="background: rgba(0,0,0,0.05); border-radius: 30px; margin: 8px 10px; padding: 5px 15px 5px 5px; display: flex; align-items: center; transition: background 0.2s;">
                            <img src="<?php echo $user_avatar; ?>" class="user-image" alt="User Image" style="margin-right: 10px;">
                            <span class="hidden-xs" style="font-weight: 600;"><?php echo isset($current_user) ? $current_user['nama'] : ''; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="App.confirm('Sign Out?', 'Are you sure you want to end your secure session?', function(){ window.location.href='<?php echo base_url('auth/logout'); ?>'; });" title="Secure Logout" style="color: #ef4444; font-size: 16px;">
                            <i class="fa fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo $user_avatar; ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo isset($current_user) ? $current_user['nama'] : ''; ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <?php if (isset($menu) && is_array($menu)): ?>
                <?php foreach ($menu as $m): ?>
                    <?php 
                        $is_active = ($current_uri == $m['menu_link']);
                        $has_active_child = false;
                        if (isset($m['children'])) {
                            foreach ($m['children'] as $child) {
                                if ($current_uri == $child['menu_link']) $has_active_child = true;
                            }
                        }
                    ?>
                    <?php if (isset($m['children']) && !empty($m['children'])): ?>
                    <li class="treeview <?php echo ($is_active || $has_active_child) ? 'active' : ''; ?>">
                        <a href="#"><i class="<?php echo $m['menu_icon']; ?>"></i> <span><?php echo $m['menu_name']; ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($m['children'] as $child): ?>
                            <li class="<?php echo ($current_uri == $child['menu_link']) ? 'active' : ''; ?>">
                                <a href="<?php echo base_url($child['menu_link']); ?>"><i class="<?php echo $child['menu_icon']; ?>"></i> <?php echo $child['menu_name']; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="<?php echo $is_active ? 'active' : ''; ?>">
                        <a href="<?php echo base_url($m['menu_link']); ?>"><i class="<?php echo $m['menu_icon']; ?>"></i> <span><?php echo $m['menu_name']; ?></span></a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </section>
    </aside>
    <?php endif; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <?php echo isset($title) ? $title : 'Dashboard'; ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
                    <?php foreach ($breadcrumbs as $b): ?>
                        <li><a href="<?php echo $b['link'] != '#' ? base_url($b['link']) : 'javascript:void(0)'; ?>"><?php echo $b['name']; ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </section>
        <section class="content">
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <?php echo isset($contents) ? $contents : ''; ?>
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> <?php echo isset($sys_app_version) ? $sys_app_version : '1.0.0'; ?>
        </div>
        <strong><?php echo isset($sys_footer_text) ? $sys_footer_text : '&copy; Starter Kit'; ?></strong>
    </footer>
</div>

<!-- GLOBAL AJAX LOADER OVERLAY -->
<div id="globalAjaxOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(255, 255, 255, 0.7); z-index: 9999; backdrop-filter: blur(2px);">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
        <i class="fa fa-circle-o-notch fa-spin text-primary" style="font-size: 48px;"></i>
        <h4 style="margin-top: 15px; font-weight: 600; color: #1e293b;">Processing...</h4>
        <p style="color: #64748b; font-size: 13px;">Please wait while we secure your data.</p>
    </div>
</div>

<script src="<?php echo base_url('assets/starter_kit/vendor/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/dataTables.bootstrap.min.js'); ?>"></script>
<!-- DataTables Buttons -->
<script src="<?php echo base_url('assets/starter_kit/vendor/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/buttons.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/jszip.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/pdfmake.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/vfs_fonts.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/starter_kit/vendor/buttons.colVis.min.js'); ?>"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url('assets/starter_kit/vendor/sweetalert2.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/starter_kit/vendor/adminlte.min.js'); ?>"></script>
<script>
    // Standar Global Modal CI3 Enterprise
    if (typeof $.fn.modal !== 'undefined') {
        $.fn.modal.Constructor.DEFAULTS.backdrop = 'static';
        $.fn.modal.Constructor.DEFAULTS.keyboard = false;
    }

    // Standarisasi SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Helper Global untuk Alert yang seragam
    const App = {
        alert: (title, message, type = 'success') => {
            return Swal.fire({
                title: title,
                text: message,
                icon: type,
                confirmButtonColor: '#3085d6'
            });
        },
        confirm: (title, message, callback) => {
            Swal.fire({
                title: title,
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        },
        toast: (message, type = 'success') => {
            Toast.fire({
                icon: type,
                title: message
            });
        },
        showLoader: () => {
            $('#globalAjaxOverlay').fadeIn(200);
        },
        hideLoader: () => {
            $('#globalAjaxOverlay').fadeOut(200);
        }
    };

    // Global AJAX Interceptor -> Auto-locking UI Anti-Spam
    $(document).ajaxStart(function () {
        App.showLoader();
    }).ajaxStop(function () {
        App.hideLoader();
    });

    // Auto-inject CSRF Token to ALL jQuery AJAX POST requests
    $.ajaxSetup({
        beforeSend: function(xhr, settings) {
            if (settings.type.toUpperCase() == 'POST') {
                if (settings.data === undefined || settings.data === null) {
                    settings.data = CSRF_NAME + '=' + encodeURIComponent(CSRF_HASH);
                } else if (typeof settings.data === 'string') {
                    if (settings.data.indexOf(CSRF_NAME + '=') === -1) {
                        settings.data += (settings.data.length > 0 ? '&' : '') + CSRF_NAME + '=' + encodeURIComponent(CSRF_HASH);
                    }
                } else if (typeof settings.data === 'object' && !(settings.data instanceof FormData)) {
                    settings.data[CSRF_NAME] = CSRF_HASH;
                } else if (settings.data instanceof FormData) {
                    if (!settings.data.has(CSRF_NAME)) {
                        settings.data.append(CSRF_NAME, CSRF_HASH);
                    }
                }
            }
        }
    });

    /* ========================================================= */
    /* GLOBAL ENTERPRISE FORM FORMATTER (Email & Phone) */
    /* ========================================================= */
    // 1. Auto-lowercase for Email fields in all modals
    $(document).on('input', '.modal input[type="email"], .modal input[name*="email"]', function() {
        let start = this.selectionStart;
        let end = this.selectionEnd;
        this.value = this.value.toLowerCase();
        this.setSelectionRange(start, end);
    });

    // 2. Strict Numeric & Telephony characters for Phone fields
    $(document).on('input', '.modal input[type="tel"], .modal input[name*="telp"], .modal input[name*="telepon"], .modal input[name*="phone"], .modal input[name*="nohp"]', function() {
        let start = this.selectionStart;
        let originalValue = this.value;
        // Clean characters leaving only 0-9, +, -, spaces and parentheses
        let cleanedValue = originalValue.replace(/[^0-9\+\-\(\)\s]/g, '');
        
        if (originalValue !== cleanedValue) {
            this.value = cleanedValue;
            this.setSelectionRange(start - 1, start - 1);
        }
    });


</script>
</body>
</html>
