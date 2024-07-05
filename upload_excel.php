<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Upload Section -->
<section class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Upload Excel</h5>
            <form method="post" enctype="multipart/form-data" action="process_excel.php">
                <div class="form-group">
                    <label for="file">Select File:</label>
                    <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx" required>
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" id="pass" name="password"  minlength="32" maxlength="32" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
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
