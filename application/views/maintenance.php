<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Maintenance | <?php echo isset($sys_app_name) ? $sys_app_name : 'Enterprise Portal'; ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/font-awesome.min.css'); ?>">
    
    <style>
        :root {
            --indigo-600: #4f46e5;
            --indigo-700: #4338ca;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-400: #94a3b8;
            --slate-600: #475569;
            --slate-900: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--slate-50);
            color: var(--slate-900);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.05) 0px, transparent 50%);
        }

        .container {
            max-width: 600px;
            width: 90%;
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 32px;
            border: 1px solid var(--slate-100);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .icon-box {
            width: 100px;
            height: 100px;
            background: rgba(79, 70, 229, 0.08);
            color: var(--indigo-600);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.2); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(79, 70, 229, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
        }

        h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 15px;
            color: var(--slate-900);
        }

        p {
            color: var(--slate-600);
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .message-box {
            background: var(--slate-50);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid var(--indigo-600);
            text-align: left;
        }

        .message-label {
            font-size: 11px;
            font-weight: 800;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: block;
        }

        .message-content {
            font-weight: 600;
            color: var(--slate-900);
        }

        .footer-note {
            font-size: 13px;
            color: var(--slate-400);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        /* Decorative elements */
        .decor {
            position: absolute;
            z-index: -1;
            opacity: 0.5;
        }
        .decor-1 { top: -20px; left: -20px; color: var(--indigo-600); }
        .decor-2 { bottom: -20px; right: -20px; color: var(--slate-400); }

    </style>
</head>
<body>

    <div class="container">
        <div class="icon-box">
            <i class="fa fa-wrench"></i>
        </div>

        <h1>Infrastructure Maintenance</h1>
        <p>System administrators are currently performing scheduled enhancements. Operations are paused to ensure data integrity and system stability.</p>

        <?php if (!empty($message)): ?>
        <div class="message-box">
            <span class="message-label">Special Broadcast</span>
            <div class="message-content"><?php echo $message; ?></div>
        </div>
        <?php endif; ?>

        <div class="footer-note">
            <div class="status-dot"></div>
            Management node is currently locked. Please try again soon.
        </div>
    </div>

    <div class="decor decor-1"><i class="fa fa-cog fa-spin fa-3x"></i></div>
    <div class="decor decor-2"><i class="fa fa-server fa-4x"></i></div>

</body>
</html>
