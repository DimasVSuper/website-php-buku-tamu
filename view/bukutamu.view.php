<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tamu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: linear-gradient(135deg, #a259c6 0%, #6d28d9 100%);
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
        color: #6d28d9;
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
        background: #a259c6;
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
        background: #6d28d9;
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
        background: #a259c6;
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
        color: #a259c6;
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
<div id="app" class="container">
    <h2>Buku Tamu</h2>
    <form @submit.prevent="onSubmit">
        <input type="hidden" v-model="form.id">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" v-model="form.nama" required>

        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required>

        <label for="pesan">Pesan:</label>
        <textarea id="pesan" v-model="form.pesan" rows="4" required></textarea>

        <button type="submit" id="submitBtn">{{ form.id ? 'Update' : 'Kirim' }}</button>
        <button type="button" id="cancelEditBtn"
            v-if="form.id"
            @click="resetForm"
            style="background:#e0e0e0;color:#374151;">Batal</button>
    </form>
    <div id="popup" :class="{show: popup.show, error: !popup.success}" v-text="popup.message"></div>
    <div class="tamu-list" id="tamuList">
        <div v-if="tamuList.length === 0" style="text-align:center;color:#aaa;">Belum ada tamu.</div>
        <div v-for="item in tamuList" :key="item.id" class="tamu-item">
            <div class="tamu-info">
                <span class="tamu-nama">{{ item.nama }}</span>
                <span class="tamu-email">&lt;{{ item.email }}&gt;</span>
            </div>
            <div class="tamu-pesan">{{ item.pesan }}</div>
            <div class="tamu-actions">
                <button class="btn btn-edit" @click="editTamu(item)">Edit</button>
                <button class="btn btn-delete" @click="hapusTamu(item.id)">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3"></script>
<script>
const { createApp, reactive } = Vue;

createApp({
    data() {
        return {
            tamuList: [],
            form: {
                id: '',
                nama: '',
                email: '',
                pesan: ''
            },
            popup: {
                show: false,
                message: '',
                success: true
            }
        }
    },
    mounted() {
        this.fetchTamuList();
    },
    methods: {
        showPopup(message, success = true) {
            this.popup.message = message;
            this.popup.success = success;
            this.popup.show = true;
            setTimeout(() => {
                this.popup.show = false;
            }, 2000);
        },
        fetchTamuList() {
            fetch('tamu')
                .then(res => res.json())
                .then(data => {
                    this.tamuList = data || [];
                })
                .catch(() => {
                    this.tamuList = [];
                    this.showPopup('Gagal memuat data tamu.', false);
                });
        },
        validateForm() {
            const { nama, email, pesan } = this.form;
            if (!nama.trim() || !email.trim() || !pesan.trim()) {
                this.showPopup('Semua field wajib diisi!', false);
                return false;
            }
            if (nama.length > 100) {
                this.showPopup('Nama maksimal 100 karakter!', false);
                return false;
            }
            if (email.length > 100) {
                this.showPopup('Email maksimal 100 karakter!', false);
                return false;
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                this.showPopup('Format email tidak valid!', false);
                return false;
            }
            if (pesan.length > 1000) {
                this.showPopup('Pesan maksimal 1000 karakter!', false);
                return false;
            }
            return true;
        },
        onSubmit() {
            if (!this.validateForm()) return;
            if (this.form.id) {
                // Update
                fetch('tamu/update', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form)
                })
                .then(res => res.text())
                .then(data => {
                    this.resetForm();
                    this.fetchTamuList();
                    if (data.toLowerCase().includes('berhasil')) {
                        this.showPopup('Data berhasil diupdate', true);
                    } else {
                        this.showPopup('Ada yang salah, silahkan coba lagi', false);
                    }
                })
                .catch(() => this.showPopup('Ada yang salah, silahkan coba lagi', false));
            } else {
                // Tambah
                fetch('tamu', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form)
                })
                .then(res => res.text())
                .then(data => {
                    this.resetForm();
                    this.fetchTamuList();
                    if (data.toLowerCase().includes('berhasil')) {
                        this.showPopup('Data berhasil di kirim', true);
                    } else {
                        this.showPopup('Ada yang salah, silahkan coba lagi', false);
                    }
                })
                .catch(() => this.showPopup('Ada yang salah, silahkan coba lagi', false));
            }
        },
        editTamu(item) {
            this.form.id = item.id;
            this.form.nama = item.nama;
            this.form.email = item.email;
            this.form.pesan = item.pesan;
        },
        hapusTamu(id) {
            if (!confirm('Yakin ingin menghapus data ini?')) return;
            fetch('tamu/delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(res => res.text())
            .then(data => {
                this.fetchTamuList();
                if (data.toLowerCase().includes('berhasil')) {
                    this.showPopup('Data berhasil dihapus', true);
                } else {
                    this.showPopup('Gagal menghapus data', false);
                }
            })
            .catch(() => this.showPopup('Gagal menghapus data', false));
        },
        resetForm() {
            this.form.id = '';
            this.form.nama = '';
            this.form.email = '';
            this.form.pesan = '';
        }
    }
}).mount('#app');
</script>
</body>
</html>