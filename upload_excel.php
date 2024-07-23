<?php
// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Rest of your PHP code
?>
<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// If it's desired to delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

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
                    <input type="password" class="form-control" id="pass" name="password" minlength="16" maxlength="16" required>
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
