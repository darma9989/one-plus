<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak | 403 Forbidden</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f59e0b; /* Amber */
            --primary-dark: #d97706;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-600: #475569;
            --slate-900: #0f172a;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--slate-50);
            color: var(--slate-900);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            width: 100%;
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }
        .icon-lock {
            font-size: 80px;
            color: var(--primary);
            margin-bottom: 20px;
            animation: shake 2s infinite;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        h1 { margin-bottom: 15px; font-size: 26px; font-weight: 800; color: #1e293b; }
        .message { color: var(--slate-600); line-height: 1.6; margin-bottom: 30px; font-size: 15px; }
        .btn {
            display: inline-block;
            background: #1e293b;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn:hover {
            background: var(--slate-600);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-lock">
            🔒
        </div>
        <h1>Akses Ditolak (403)</h1>
        <div class="message">
            <?php echo isset($message) ? $message : 'Sistem mendeteksi bahwa peran Anda saat ini tidak memiliki izin untuk membuka halaman tersebut.<br><br><b>Silakan hubungi Administrator sistem</b> apabila Anda membutuhkan akses ke modul ini.'; ?>
        </div>
        <a href="<?php echo config_item('base_url'); ?>dashboard" class="btn">Kembali ke Dashboard Utama</a>
    </div>
</body>
</html>
