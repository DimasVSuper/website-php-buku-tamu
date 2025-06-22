<?php

class BukutamuModel {
    private $file;

    public function __construct() {
        $this->file = __DIR__ . '/bukutamu.json';
        if (!file_exists($this->file)) {
            file_put_contents($this->file, '[]');
        }
    }

    // CREATE
    public function create($data) {
        $list = $this->show();
        // Generate ID unik (timestamp + random)
        $data['id'] = uniqid();
        $list[] = $data;
        return file_put_contents($this->file, json_encode($list, JSON_PRETTY_PRINT));
    }

    // READ
    public function show() {
        $json = file_get_contents($this->file);
        return json_decode($json, true) ?: [];
    }

    // UPDATE
    public function update($data) {
        $list = $this->show();
        $found = false;
        foreach ($list as &$item) {
            if ($item['id'] === $data['id']) {
                $item['nama'] = $data['nama'];
                $item['email'] = $data['email'];
                $item['pesan'] = $data['pesan'];
                $found = true;
                break;
            }
        }
        if ($found) {
            return file_put_contents($this->file, json_encode($list, JSON_PRETTY_PRINT));
        }
        return false;
    }

    // DELETE
    public function delete($id) {
        $list = $this->show();
        $newList = array_filter($list, function($item) use ($id) {
            return $item['id'] !== $id;
        });
        return file_put_contents($this->file, json_encode(array_values($newList), JSON_PRETTY_PRINT));
    }

    public function simpan($data) {
        return $this->create($data)
            ? "Terima kasih, data berhasil disimpan!"
            : "Gagal menyimpan data.";
    }
}