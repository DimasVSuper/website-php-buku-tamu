<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/../controller/BukutamuController.php';

$router = new Router();

// Halaman utama (form buku tamu)
$router->get('/', function() {
    require __DIR__ . '/../view/bukutamu.view.php';
});

// CREATE: Simpan data buku tamu (AJAX POST)
$router->post('/buku-tamu/simpan', function() {
    $controller = new BukutamuController();
    $data = [
        'nama'  => $_POST['nama'] ?? '',
        'email' => $_POST['email'] ?? '',
        'pesan' => $_POST['pesan'] ?? ''
    ];
    echo $controller->simpan($data);
});

// READ: Tampilkan semua data buku tamu (AJAX GET)
$router->get('/buku-tamu/data', function() {
    $controller = new BukutamuController();
    header('Content-Type: application/json');
    echo json_encode($controller->tampil());
});

// UPDATE: Update data buku tamu (AJAX PUT)
$router->put('/buku-tamu/update', function() {
    parse_str(file_get_contents("php://input"), $put_vars);
    $controller = new BukutamuController();
    // Pastikan $put_vars mengandung 'id', 'nama', 'email', 'pesan'
    echo $controller->update($put_vars);
});

// DELETE: Hapus data buku tamu (AJAX DELETE)
$router->delete('/buku-tamu/hapus', function() {
    parse_str(file_get_contents("php://input"), $del_vars);
    $controller = new BukutamuController();
    // Pastikan $del_vars['id'] tersedia
    echo $controller->hapus($del_vars['id'] ?? null);
});

// Jalankan router
$router->dispatch();