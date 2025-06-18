<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tamu</title>
</head>
<body>
    <header>
        <h2>Buku Tamu Form</h2>
    </header>
    <?php include __DIR__ . '/layout/formtamu.layout.php'; ?>

    <script>
    document.getElementById('bukuTamuForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('/bukutamu/simpan', { // Disesuaikan ke endpoint POST simpan
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('response').innerHTML = data;
            form.reset();
        })
        .catch(error => {
            document.getElementById('response').innerHTML = 'Terjadi kesalahan. Silakan coba lagi.';
        });
    });
    </script>
</body>
</html>