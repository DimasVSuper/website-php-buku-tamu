<?php

class BukutamuModel {
    private $file = __DIR__ . './bukutamu.json';
    private $data = [];

    public function __construct() {
        if (file_exists($this->file)) {
            $json = file_get_contents($this->file);
            $this->data = json_decode($json, true) ?: [];
        }
    }

    // CREATE
    public function save($data) {
        $data['id'] = uniqid();
        $this->data[] = $data;
        return $this->commit();
    }

    // READ
    public function show() {
        // Urutkan dari terbaru
        return array_reverse($this->data);
    }

    // UPDATE
    public function update($data) {
        foreach ($this->data as $i => $item) {
            if ($item['id'] === $data['id']) {
                $this->data[$i] = array_merge($item, $data);
                return $this->commit();
            }
        }
        return false;
    }

    // DELETE
    public function delete($id) {
        foreach ($this->data as $i => $item) {
            if ($item['id'] === $id) {
                array_splice($this->data, $i, 1);
                return $this->commit();
            }
        }
        return false;
    }

    // Simpan ke file JSON
    private function commit() {
        return file_put_contents($this->file, json_encode($this->data, JSON_PRETTY_PRINT)) !== false;
    }
}