<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controller/BukutamuController.php';

$router = new Router();

// Halaman utama (form buku tamu)
$router->get('/', function() {
    require __DIR__ . '/../view/bukutamu.view.php';
});
$router->get('', function() {
    require __DIR__ . '/../view/bukutamu.view.php';
});

// CREATE: Tambah tamu (POST /tamu)
$router->post('tamu', function() {
    $controller = new BukutamuController();
    $data = json_decode(file_get_contents("php://input"), true);
    echo $controller->simpan($data);
});

// READ: Ambil semua tamu (GET /tamu)
$router->get('tamu', function() {
    $controller = new BukutamuController();
    header('Content-Type: application/json');
    echo json_encode($controller->tampil());
});

// UPDATE: Update tamu (POST /tamu/update)
$router->post('tamu/update', function() {
    $controller = new BukutamuController();
    $data = json_decode(file_get_contents("php://input"), true);
    echo $controller->update($data);
});

// DELETE: Hapus tamu (POST /tamu/delete)
$router->post('tamu/delete', function() {
    $controller = new BukutamuController();
    $data = json_decode(file_get_contents("php://input"), true);
    echo $controller->hapus($data['id'] ?? '');
});

$router->dispatch();