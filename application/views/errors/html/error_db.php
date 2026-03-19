<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error | Enterprise Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #06b6d4;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-600: #475569;
            --slate-900: #0f172a;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--slate-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            width: 100%;
            text-align: center;
            padding: 50px;
            background: #fff;
            border-radius: 40px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.05);
            border-bottom: 8px solid var(--primary);
        }
        img {
            max-width: 280px;
            margin-bottom: 20px;
        }
        h1 { margin-bottom: 20px; font-size: 28px; font-weight: 800; color: var(--slate-900); }
        .message-box {
            background: #fdfdfd;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            margin-bottom: 30px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            color: #ef4444;
        }
        .btn {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            padding: 14px 28px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?php echo config_item('base_url'); ?>uploads/system/database_error_illustration.png" alt="Database Error">
        <h1>Gagal Memproses Data</h1>
        <div class="message-box">
            <strong><?php echo $heading; ?></strong>
            <div style="margin-top:10px;"><?php echo $message; ?></div>
        </div>
        <p style="color:var(--slate-600); margin-bottom: 20px;">Kami sedang bekerja untuk memperbaiki koneksi database kami. Silakan coba beberapa saat lagi.</p>
        <a href="javascript:location.reload()" class="btn">Segarkan Halaman</a>
    </div>
</body>
</html>
