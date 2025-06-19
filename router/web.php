<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controller/BukutamuController.php';

$router = new Router();

// Halaman utama (form buku tamu)
$router->get('/', function() {
    require __DIR__ . '/../view/bukutamu.view.php';
});
$router->get('', function() { // Tambahkan ini!
    require __DIR__ . '/../view/bukutamu.view.php';
});

// CREATE: Simpan data buku tamu (AJAX POST)
$router->post('simpan', function() {
    $controller = new BukutamuController();
    $data = [
        'nama'  => $_POST['nama'] ?? '',
        'email' => $_POST['email'] ?? '',
        'pesan' => $_POST['pesan'] ?? ''
    ];
    echo $controller->simpan($data);
});

// READ: Tampilkan semua data buku tamu (AJAX GET)
$router->get('data', function() {
    $controller = new BukutamuController();
    header('Content-Type: application/json');
    echo json_encode($controller->tampil());
});

// UPDATE: Update data buku tamu (AJAX PATCH)
$router->patch('update', function() {
    $patch_vars = json_decode(file_get_contents("php://input"), true);
    error_log('PATCH DATA: ' . print_r($patch_vars, true));
    $controller = new BukutamuController();
    echo $controller->update($patch_vars);
});

// DELETE: Hapus data buku tamu (AJAX POST/DELETE)
$router->post('hapus', function() {
    $controller = new BukutamuController();
    $id = $_POST['id'] ?? '';
    echo $controller->hapus($id);
});
$router->delete('hapus', function() {
    parse_str(file_get_contents("php://input"), $del_vars);
    $controller = new BukutamuController();
    echo $controller->hapus($del_vars['id'] ?? null);
});

// Jalankan router
$router->dispatch();