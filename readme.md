# Buku Tamu PHP Sederhana

Aplikasi Buku Tamu berbasis PHP, JSON, dan AJAX dengan konsep MVC sederhana dan routing OOP.

---

## Fitur

- **CRUD Buku Tamu** (Create, Read, Update, Delete)
- Data disimpan di file JSON (`model/bukutamu.json`)
- Routing OOP fleksibel (lihat folder `router/`)
- AJAX tanpa reload halaman (lihat `view/bukutamu.view.php`)
- Tampilan modern (Neve style)
- Halaman 404 custom

---

## Struktur Folder

```
controller/
    BukutamuController.php
model/
    BukutamuModel.php
    bukutamu.json
router/
    router.php
    web.php
view/
    bukutamu.view.php
    404.view.php
.htaccess
index.php
```

---

## Algoritma & Struktur Data

- **Struktur Data:**  
  Data buku tamu disimpan dalam bentuk **array (list/sequence)** di file JSON.
- **Algoritma Tambah:**  
  Data baru selalu ditambahkan di akhir array, sehingga urutan input tetap terjaga.
- **Algoritma Update:**  
  Data diubah langsung pada index yang sesuai (berdasarkan `id`), tanpa mengubah urutan array.
- **Algoritma Hapus:**  
  Data dihapus dari array berdasarkan `id`, index lain tetap.
- **Catatan:**  
  Dengan cara ini, urutan data tetap stabil: data pertama tetap di index pertama, data lain tetap di posisi aslinya walau diubah.

---

## Cara Menjalankan

1. **Copy** seluruh folder ke dalam `htdocs` XAMPP.
2. **Pastikan** file `.htaccess` ada di folder `buku-tamu` dan `mod_rewrite` aktif di Apache.
3. **Jalankan** Apache dari XAMPP.
4. **Akses** aplikasi melalui browser:
   ```
   http://localhost/buku-tamu/
   ```
5. **Isi form buku tamu** dan klik Kirim. Data akan tersimpan di `model/bukutamu.json`.

---

## Catatan

- Endpoint AJAX menggunakan path relatif (`simpan`, `data`, `update`, `hapus`) agar fleksibel.
- Jika ingin mengubah tampilan, edit file di `view/`.
- Jika ingin menambah fitur, tambahkan route di `router/web.php` dan logic di controller/model.

---

## Lisensi

MIT &copy; 2025 Dimas Bayu Nugroho