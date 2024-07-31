<?php
// Mencegah caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Memulai sesi dan menghapus data yang ada
session_start();
$_SESSION = [];

// Memeriksa cookie sesi dan menghapusnya jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Akhirnya, menghancurkan sesi
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enkripsi File dengan AES-128</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Bagian Upload untuk Enkripsi -->
<section class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Enkripsi File DOCX/PDF Anda</h5>
            <p class="card-text">Unggah file DOCX atau PDF untuk dienkripsi menggunakan enkripsi AES-128. Masukkan kunci 16 karakter untuk enkripsi.</p>
            <form method="post" enctype="multipart/form-data" action="process_docx_pdf.php">
                <div class="form-group">
                    <label for="file">Pilih File (hanya DOCX atau PDF):</label>
                    <input type="file" class="form-control-file" id="file" name="file" accept=".docx,.pdf" required>
                    <label for="pass">Kunci Enkripsi (16 karakter):</label>
                    <input type="password" class="form-control" id="pass" name="password" minlength="16" maxlength="16" placeholder="Masukkan kunci 16 karakter" required>
                </div>
                <button type="submit" class="btn btn-primary">Enkripsi File</button>
            </form>
        </div>
    </div>
</section>

<!-- Bootstrap JS dan dependensi -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
