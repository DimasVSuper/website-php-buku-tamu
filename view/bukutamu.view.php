<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tamu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: #f6f8fa;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 420px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(60,72,88,0.08);
        padding: 32px 28px 24px 28px;
    }
    h2 {
        color: #1a237e;
        text-align: center;
        margin-bottom: 24px;
        font-weight: 600;
        letter-spacing: 1px;
    }
    form label {
        display: block;
        margin-bottom: 6px;
        color: #374151;
        font-size: 15px;
        font-weight: 500;
    }
    form input, form textarea {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 18px;
        border: 1px solid #e0e6ed;
        border-radius: 8px;
        font-size: 15px;
        background: #f9fafb;
        transition: border-color 0.2s;
        resize: none;
    }
    form input:focus, form textarea:focus {
        border-color: #1976d2;
        outline: none;
        background: #fff;
    }
    button[type="submit"] {
        width: 100%;
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 0;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(25,118,210,0.08);
        transition: background 0.2s;
    }
    button[type="submit"]:hover {
        background: #1565c0;
    }
    #response {
        margin-top: 18px;
        text-align: center;
        font-size: 15px;
        color: #388e3c;
        min-height: 22px;
    }
    #popup {
        position: fixed;
        left: 50%;
        top: 18%;
        transform: translate(-50%, -50%) scale(1);
        min-width: 220px;
        max-width: 90vw;
        padding: 16px 28px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        box-shadow: 0 4px 24px rgba(60,72,88,0.13);
        z-index: 9999;
        text-align: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s, transform 0.3s;
        background: #1976d2;
        color: #fff;
        display: block;
        visibility: hidden;
    }
    #popup.show {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1.05);
        pointer-events: auto;
        visibility: visible;
    }
    #popup.error {
        background: #d32f2f;
    }
    @media (max-width: 600px) {
        .container {
            margin: 16px;
            padding: 18px 8px 12px 8px;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Buku Tamu</h2>
        <form id="bukuTamuForm" method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="4" required></textarea>

            <button type="submit">Kirim</button>
        </form>
        <div id="response"></div>
        <div id="popup"></div>
    </div>

    <script>
    function showPopup(message, success = true) {
        const popup = document.getElementById('popup');
        popup.textContent = message;
        popup.style.background = success ? '#1976d2' : '#d32f2f';
        popup.style.opacity = '1';
        popup.style.visibility = 'visible';
        popup.style.transform = 'translate(-50%, -50%) scale(1.05)';
        setTimeout(() => {
            popup.style.opacity = '0';
            popup.style.visibility = 'hidden';
            popup.style.transform = 'translate(-50%, -50%) scale(0.95)';
        }, 2000);
    }

    document.getElementById('bukuTamuForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('buku-tamu/simpan', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            form.reset();
            if (data.toLowerCase().includes('berhasil')) {
                showPopup('Data berhasil di kirim', true);
            } else {
                showPopup('Ada yang salah, silahkan coba lagi', false);
            }
        })
        .catch(error => {
            showPopup('Ada yang salah, silahkan coba lagi', false);
        });
    });
    </script>
</body>
</html>