<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Halaman Tidak Ditemukan | Enterprise Portal</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
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
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.03) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.03) 0px, transparent 50%);
        }

        .error-container {
            max-width: 800px;
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 60px;
            padding: 60px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.05);
        }

        .illustration-side {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .illustration-side img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.1));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .content-side {
            flex: 1;
            text-align: left;
        }

        .error-code {
            font-size: 120px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -5px;
        }

        h2 {
            font-size: 32px;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 20px;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        p {
            color: var(--slate-600);
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--primary);
            color: #fff;
            padding: 16px 32px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .btn-home:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.5);
        }

        .btn-home svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 768px) {
            .error-container {
                flex-direction: column;
                padding: 40px 30px;
                text-align: center;
                gap: 30px;
            }
            .content-side {
                text-align: center;
            }
            .error-code {
                font-size: 80px;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="content-side">
            <div class="error-code">404</div>
            <h2>Ups! Halaman Tersebut Tidak Ditemukan</h2>
            <p>Sepertinya halaman yang Anda cari telah dipindahkan atau tidak pernah ada. Silakan kembali ke halaman utama kami.</p>
            <a href="<?php echo config_item('base_url'); ?>" class="btn-home">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
        <div class="illustration-side">
            <img src="<?php echo config_item('base_url'); ?>uploads/system/404_illustration.png" alt="Lost Page">
        </div>
    </div>

</body>
</html>
