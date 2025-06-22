<?php

require_once __DIR__ . '/../config/MySql.php';

class BukutamuModel {
    private $pdo;

    public function __construct() {
        $db = new MySql();
        $this->pdo = $db->getConnection();
    }

    // CREATE
    public function create($data) {
        $sql = "INSERT INTO tamu (nama, email, pesan) VALUES (:nama, :email, :pesan)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nama'  => $data['nama'],
            ':email' => $data['email'],
            ':pesan' => $data['pesan']
        ]);
    }

    // READ
    public function show() {
        $sql = "SELECT * FROM tamu ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // UPDATE
    public function update($data) {
        $sql = "UPDATE tamu SET nama = :nama, email = :email, pesan = :pesan WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nama'  => $data['nama'],
            ':email' => $data['email'],
            ':pesan' => $data['pesan'],
            ':id'    => $data['id']
        ]);
    }

    // DELETE
    public function delete($id) {
        $sql = "DELETE FROM tamu WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function simpan($data) {
        return $this->create($data)
            ? "Terima kasih, data berhasil disimpan!"
            : "Gagal menyimpan data.";
    }
}