<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dekripsi File Excel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Section for Excel File Decryption -->
<section class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Dekripsi File Excel</h5>
            <p class="card-text">Unggah file Excel yang telah dienkripsi untuk didekripsi. Masukkan kunci dekripsi yang sama yang digunakan saat enkripsi.</p>
            <form method="post" enctype="multipart/form-data" action="process_excel.php">
                <div class="form-group">
                    <label for="file">Pilih File Excel (hanya format .xlsx):</label>
                    <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx" required>
                    <label for="pass">Kunci Dekripsi (16 karakter):</label>
                    <input type="password" class="form-control" id="pass" name="password" minlength="16" maxlength="16" placeholder="Masukkan kunci 16 karakter" required>
                </div>
                <button type="submit" class="btn btn-primary">Dekripsi File</button>
            </form>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
