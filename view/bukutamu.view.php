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
        max-width: 480px;
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
    button[type="submit"], .btn {
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(25,118,210,0.08);
        transition: background 0.2s;
        margin-right: 6px;
    }
    button[type="submit"]:hover, .btn:hover {
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
    .tamu-list {
        margin-top: 32px;
    }
    .tamu-item {
        background: #f9fafb;
        border-radius: 8px;
        padding: 14px 14px 10px 14px;
        margin-bottom: 14px;
        box-shadow: 0 1px 4px rgba(60,72,88,0.06);
        position: relative;
        transition: box-shadow 0.2s;
    }
    .tamu-item.editing {
        background: #e3f2fd;
        box-shadow: 0 2px 8px rgba(25,118,210,0.10);
    }
    .tamu-item .tamu-info {
        margin-bottom: 6px;
    }
    .tamu-item .tamu-nama {
        font-weight: 600;
        color: #1976d2;
        font-size: 16px;
    }
    .tamu-item .tamu-email {
        color: #374151;
        font-size: 14px;
        margin-left: 8px;
    }
    .tamu-item .tamu-pesan {
        color: #374151;
        font-size: 15px;
        margin-bottom: 8px;
    }
    .tamu-item .tamu-actions {
        text-align: right;
    }
    .btn-edit {
        background: #fff3e0;
        color: #ff9800;
        border: 1px solid #ffe0b2;
    }
    .btn-edit:hover {
        background: #ffe0b2;
        color: #e65100;
    }
    .btn-delete {
        background: #ffebee;
        color: #d32f2f;
        border: 1px solid #ffcdd2;
    }
    .btn-delete:hover {
        background: #ffcdd2;
        color: #b71c1c;
    }
    .edit-form input, .edit-form textarea {
        margin-bottom: 10px;
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
            <input type="hidden" id="editId" name="id">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="4" required></textarea>

            <button type="submit" id="submitBtn">Kirim</button>
            <button type="button" id="cancelEditBtn" style="display:none;background:#e0e0e0;color:#374151;">Batal</button>
        </form>
        <div id="response"></div>
        <div id="popup"></div>
        <div class="tamu-list" id="tamuList"></div>
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

    function renderTamuList(data) {
        const list = document.getElementById('tamuList');
        if (!data || data.length === 0) {
            list.innerHTML = '<div style="text-align:center;color:#aaa;">Belum ada tamu.</div>';
            return;
        }
        list.innerHTML = '';
        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'tamu-item';
            div.dataset.id = item.id;
            div.innerHTML = `
                <div class="tamu-info">
                    <span class="tamu-nama">${item.nama}</span>
                    <span class="tamu-email">&lt;${item.email}&gt;</span>
                </div>
                <div class="tamu-pesan">${item.pesan}</div>
                <div class="tamu-actions">
                    <button class="btn btn-edit" data-id="${item.id}">Edit</button>
                    <button class="btn btn-delete" data-id="${item.id}">Hapus</button>
                </div>
            `;
            list.appendChild(div);
        });
    }

    function fetchTamuList() {
        fetch('data')
            .then(res => res.json())
            .then(data => renderTamuList(data))
            .catch(() => {
                document.getElementById('tamuList').innerHTML = '<div style="text-align:center;color:#d32f2f;">Gagal memuat data tamu.</div>';
            });
    }

    // Fungsi tambah tamu
    function tambahTamu(formData, form) {
        fetch('simpan', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            form.reset();
            document.getElementById('editId').value = '';
            document.getElementById('submitBtn').textContent = 'Kirim';
            document.getElementById('cancelEditBtn').style.display = 'none';
            fetchTamuList();
            if (data.toLowerCase().includes('berhasil')) {
                showPopup('Data berhasil di kirim', true);
            } else {
                showPopup('Ada yang salah, silahkan coba lagi', false);
            }
        })
        .catch(() => {
            showPopup('Ada yang salah, silahkan coba lagi', false);
        });
    }

    // Fungsi update tamu
    function updateTamu(formData, form) {
        const obj = {};
        for (const [key, value] of formData.entries()) {
            obj[key] = value;
        }
        fetch('update', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(obj)
        })
        .then(response => response.text())
        .then(data => {
            form.reset();
            document.getElementById('editId').value = '';
            document.getElementById('submitBtn').textContent = 'Kirim';
            document.getElementById('cancelEditBtn').style.display = 'none';
            fetchTamuList();
            if (data.toLowerCase().includes('berhasil')) {
                showPopup('Data berhasil diupdate', true);
            } else {
                showPopup('Ada yang salah, silahkan coba lagi', false);
            }
        })
        .catch(() => {
            showPopup('Ada yang salah, silahkan coba lagi', false);
        });
    }

    // Event submit form
    document.getElementById('bukuTamuForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const id = formData.get('id');
        const isEdit = id && id.trim() !== '';

        if (isEdit) {
            updateTamu(formData, form);
        } else {
            tambahTamu(formData, form);
        }
    });

    // Cancel edit
    document.getElementById('cancelEditBtn').addEventListener('click', function() {
        document.getElementById('bukuTamuForm').reset();
        document.getElementById('editId').value = '';
        document.getElementById('submitBtn').textContent = 'Kirim';
        this.style.display = 'none';
    });

    // Delegasi event untuk Edit dan Hapus
    document.getElementById('tamuList').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-edit')) {
            const id = e.target.dataset.id;
            fetch('data')
                .then(res => res.json())
                .then(data => {
                    const tamu = data.find(item => item.id === id);
                    if (tamu) {
                        document.getElementById('editId').value = tamu.id;
                        document.getElementById('nama').value = tamu.nama;
                        document.getElementById('email').value = tamu.email;
                        document.getElementById('pesan').value = tamu.pesan;
                        document.getElementById('submitBtn').textContent = 'Update';
                        document.getElementById('cancelEditBtn').style.display = 'inline-block';
                    }
                });
        }
        if (e.target.classList.contains('btn-delete')) {
            const id = e.target.dataset.id;
            if (confirm('Yakin ingin menghapus data ini?')) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('hapus', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    fetchTamuList();
                    if (data.toLowerCase().includes('berhasil')) {
                        showPopup('Data berhasil dihapus', true);
                    } else {
                        showPopup('Gagal menghapus data', false);
                    }
                })
                .catch(() => {
                    showPopup('Gagal menghapus data', false);
                });
            }
        }
    });

    // Load data awal
    fetchTamuList();
    </script>
</body>
</html>