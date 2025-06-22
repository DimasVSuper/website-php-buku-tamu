<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Tidak Ditemukan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: linear-gradient(135deg, #a259c6 0%, #6d28d9 100%);
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .container {
        max-width: 420px;
        margin: 60px auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(109,40,217,0.10);
        padding: 36px 30px 28px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .container::before {
        content: "";
        position: absolute;
        top: -60px;
        left: -60px;
        width: 160px;
        height: 160px;
        background: rgba(162,89,198,0.12);
        border-radius: 50%;
        z-index: 0;
    }
    h1 {
        font-size: 70px;
        color: #6d28d9;
        margin-bottom: 10px;
        font-weight: 800;
        letter-spacing: 2px;
        z-index: 1;
        position: relative;
        text-shadow: 0 2px 12px #a259c633;
    }
    h2 {
        color: #a259c6;
        margin-bottom: 18px;
        font-size: 24px;
        font-weight: 700;
        z-index: 1;
        position: relative;
    }
    p {
        color: #6b7280;
        font-size: 16px;
        margin-bottom: 28px;
        z-index: 1;
        position: relative;
    }
    a {
        display: inline-block;
        padding: 12px 32px;
        background: linear-gradient(90deg, #a259c6 0%, #6d28d9 100%);
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 16px;
        box-shadow: 0 2px 8px #a259c633;
        transition: background 0.2s, box-shadow 0.2s;
        z-index: 1;
        position: relative;
    }
    a:hover {
        background: linear-gradient(90deg, #6d28d9 0%, #a259c6 100%);
        box-shadow: 0 4px 16px #6d28d966;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Maaf, halaman yang Anda cari tidak tersedia.<br>
        Silakan kembali ke halaman utama.</p>
        <a href="/">Kembali ke Beranda</a>
    </div>
</body>
</html>