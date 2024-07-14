<?php
session_start();

// Define a 32-byte key for AES-256 decryption
$key = $_SESSION['password'];

// Simulated encrypted ASCII decimal string for demonstration purposes
$defaultText = '120 121 123 ...'; // Replace this with the actual encrypted ASCII decimal string

// Check if the extracted text is set in the session, if not use the default encrypted text
if (!isset($_SESSION['extractedText'])) {
    $_SESSION['extractedText'] = $defaultText;
}

$asciiDecimalsString = $_SESSION['extractedText'];

// Handle the form submission for editing text
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedText'])) {
        $_SESSION['editedText'] = $_POST['editedText'];
        header('Location: convert_to_docx_pdf.php');
        exit;
    }
}

// Debug: Print ASCII decimals string
// echo "<pre>ASCII Decimals String: $asciiDecimalsString</pre>";

// Convert the ASCII decimals back to binary data
$asciiArray = explode(' ', $asciiDecimalsString);
$encryptedDataFromAscii = '';
foreach ($asciiArray as $asciiDecimal) {
    $encryptedDataFromAscii .= chr($asciiDecimal);
}

// Debug: Print Encrypted Data in Binary Format
// echo "<pre>Encrypted Data in Binary: " . bin2hex($encryptedDataFromAscii) . "</pre>";

$method = 'aes-256-ecb';
$decryptedData = openssl_decrypt($encryptedDataFromAscii, $method, $key, OPENSSL_RAW_DATA);

// Debug: Check Decrypted Data
if ($decryptedData === false) {
    $decryptedData = 'Decryption failed. Please check the key and encrypted data. Or the data may have been tampered with.';
} else {
    // Debug: Print Decrypted Data
    // echo "<pre>Decrypted Data: $decryptedData</pre>";
    $_SESSION['decryptedData'] = $decryptedData;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Extracted Text</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Extracted Text</h2>
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-text">
                            <?php echo $asciiDecimalsString; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Edit Extracted Text</h2>
                <form action="" method="post" class="mt-4">
                    <div class="form-group">
                        <textarea name="editedText" rows="15" class="form-control" readonly><?php echo htmlspecialchars($decryptedData); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Convert to DOCX or PDF</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
