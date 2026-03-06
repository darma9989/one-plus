<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($app_name) ? $app_name : 'Starter Kit'; ?> | Secure Portal Access</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-700: #334155;
            --slate-900: #0f172a;
            --glass: rgba(255, 255, 255, 0.85);
        }

        * { margin:0; padding:0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--slate-900);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(40px);
            animation: move 20s infinite alternate;
        }
        .blob-1 { top: -100px; left: -100px; }
        .blob-2 { bottom: -100px; right: -100px; animation-delay: -5s; }

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(100px, 100px) scale(1.2); }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 45px 35px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-logo {
            font-size: 28px;
            font-weight: 800;
            color: var(--slate-900);
            display: block;
            margin-bottom: 10px;
            letter-spacing: -1px;
            text-decoration: none !important;
        }
        .login-logo span { color: var(--primary); }

        .login-subtitle {
            font-size: 14px;
            color: var(--slate-400);
            font-weight: 500;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: var(--slate-700);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 15px;
            color: var(--slate-400);
            font-size: 16px;
            transition: color 0.2s;
        }

        .login-input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            background: #fff;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            font-size: 15px;
            color: var(--slate-900);
            transition: all 0.2s;
            outline: none;
        }

        .login-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .login-input:focus + .input-icon {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert-custom {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 25px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            background: rgba(239, 68, 68, 0.05);
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: var(--slate-400);
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <a href="#" class="login-logo text-decoration-none">
                    <?php if (!empty($app_logo) && file_exists(FCPATH . 'uploads/settings/' . $app_logo)): ?>
                        <img src="<?php echo base_url('uploads/settings/'.$app_logo); ?>" alt="Identity Logo" style="max-height: 55px; margin-bottom: 5px;">
                    <?php else: ?>
                        <?php 
                            $title = isset($app_name) ? $app_name : 'Starter Kit';
                            $words = explode(' ', $title);
                            if (count($words) > 1) {
                                $first = array_shift($words);
                                echo $first . ' <span>' . implode(' ', $words) . '</span>';
                            } else {
                                echo '<span>' . $title . '</span>';
                            }
                        ?>
                    <?php endif; ?>
                </a>
                <p class="login-subtitle">Management Interface Authentication</p>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert-custom">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo base_url('auth/login'); ?>" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="form-group">
                    <label class="form-label">Authorized Username</label>
                    <div class="input-group-custom">
                        <input type="text" name="username" class="login-input" placeholder="e.g. administrator" required autofocus>
                        <i class="fa fa-user-circle input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Global Access Secret</label>
                    <div class="input-group-custom">
                        <input type="password" name="password" class="login-input" placeholder="••••••••" required>
                        <i class="fa fa-lock input-icon"></i>
                    </div>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 8px; margin-bottom: 25px;">
                    <input type="checkbox" name="remember_me" id="rememberMe" style="width: 16px; height: 16px; accent-color: var(--primary); cursor: pointer;">
                    <label for="rememberMe" style="font-size: 13px; color: var(--slate-400); font-weight: 500; cursor: pointer; margin: 0;">Remember my credentials</label>
                </div>

                <button type="submit" class="btn-login">
                    <span>AUTHENTICATE</span>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>
        
        <div class="footer-note">
            &copy; <?php echo date('Y'); ?> <?php echo isset($app_name) ? $app_name : 'Starter Kit'; ?>. All rights reserved.
            <br>
            Secure Entry Node ID: <?php echo substr(md5($_SERVER['REMOTE_ADDR']), 0, 8); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
