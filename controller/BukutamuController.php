<?php

require_once __DIR__ . '/../model/BukutamuModel.php';

class BukutamuController {
    protected $model;

    public function __construct() {
        $this->model = new BukutamuModel();
    }

    // CREATE
    public function simpan($data) {
        if (
            empty($data['nama']) ||
            empty($data['email']) ||
            empty($data['pesan'])
        ) {
            return "Semua field wajib diisi!";
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Format email tidak valid!";
        }
        if (strlen($data['nama']) > 100) {
            return "Nama terlalu panjang (maksimal 100 karakter)!";
        }
        if (strlen($data['email']) > 100) {
            return "Email terlalu panjang (maksimal 100 karakter)!";
        }
        if (strlen($data['pesan']) > 1000) {
            return "Pesan terlalu panjang (maksimal 1000 karakter)!";
        }
        return $this->model->create($data)
            ? "Terima kasih, data berhasil disimpan!"
            : "Gagal menyimpan data.";
    }

    // READ
    public function tampil() {
        return $this->model->show();
    }

    // UPDATE
    public function update($data) {
        if (
            empty($data['id']) ||
            empty($data['nama']) ||
            empty($data['email']) ||
            empty($data['pesan'])
        ) {
            return "Semua field wajib diisi!";
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Format email tidak valid!";
        }
        if (strlen($data['nama']) > 100) {
            return "Nama terlalu panjang (maksimal 100 karakter)!";
        }
        if (strlen($data['email']) > 100) {
            return "Email terlalu panjang (maksimal 100 karakter)!";
        }
        if (strlen($data['pesan']) > 1000) {
            return "Pesan terlalu panjang (maksimal 1000 karakter)!";
        }
        return $this->model->update($data)
            ? "Data berhasil diupdate!"
            : "Gagal mengupdate data.";
    }

    // DELETE
    public function hapus($id) {
        if (empty($id)) {
            return "ID tidak ditemukan!";
        }
        return $this->model->delete($id)
            ? "Data berhasil dihapus!"
            : "Gagal menghapus data.";
    }
}