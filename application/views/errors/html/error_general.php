<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan Sistem | Error</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ef4444;
            --primary-dark: #dc2626;
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
        img {
            max-width: 250px;
            margin-bottom: 30px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        h1 { margin-bottom: 10px; font-size: 24px; font-weight: 800; color: #1e293b; }
        .message { color: var(--slate-600); line-height: 1.6; margin-bottom: 30px; font-size: 15px; }
        .btn {
            display: inline-block;
            background: #1e293b;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?php echo config_item('base_url'); ?>uploads/system/general_error_illustration.png" alt="Error Illustration">
        <h1><?php echo $heading; ?></h1>
        <div class="message">
            <?php echo $message; ?>
        </div>
        <a href="javascript:history.back()" class="btn">Kembali ke Halaman Sebelumnya</a>
    </div>
</body>
</html>
