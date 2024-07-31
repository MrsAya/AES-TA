<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Conversion</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Prevent caching -->
<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">File Conversion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="upload_docx_pdf.php">Enkripsi File <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload_excel.php">Dekripsi File</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="jumbotron text-center">
    <div class="container">
        <h1 class="display-4">Welcome to File Conversion</h1>
        <p class="lead">This is a implementation Steganograph for AES Encryption.</p>
        <div class="d-flex justify-content-center">
            <a href="upload_docx_pdf.php" class="btn btn-primary mr-3">Enkripsi File</a>
            <a href="upload_excel.php" class="btn btn-success">Dekripsi File</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center">About File Conversion</h2>
        <p class="lead text-center">Designed by Muhammad Radya Wiguna - 2005548</p>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p>Designed by Muhammad Radya Wiguna - 2005548</p>
        <p>&copy; 2024 File Conversion. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" async></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" async></script>

</body>
</html>
