<?php
session_start();

// Encryption function
function encryptText($text)
{
    $key = $_SESSION['password']; // 32 bytes for AES-256
    $method = 'aes-256-ecb'; // Encryption method
    // Ensure the key length is correct
    if (strlen($key) !== 32) {
        die('Key must be 32 bytes long for AES-256.');
    }

    // Encrypt the data
    $encryptedData = openssl_encrypt($text, $method, $key, OPENSSL_RAW_DATA);

    // Convert encrypted binary data to ASCII decimal representation
    $asciiDecimals = [];
    for ($i = 0; $i < strlen($encryptedData); $i++) {
        $asciiDecimals[] = ord($encryptedData[$i]);
    }

    // Convert the ASCII decimals array to a string
    $asciiDecimalsString = implode(' ', $asciiDecimals);

    return $asciiDecimalsString;
}

if (!isset($_SESSION['extractedText'])) {
    header('Location: index.php');
    exit;
}

$extractedText = $_SESSION['extractedText'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedText'])) {
        // Encrypt the edited text before saving to session
        $editedText = encryptText($extractedText);
        $_SESSION['editedText'] = $editedText;
        header('Location: convert_to_excel.php');
        exit;
    }
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
                            <?php echo nl2br($extractedText); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Edit Extracted Text</h2>
                <form action="edit_docx_pdf.php" method="post" class="mt-4">
                    <div class="form-group">
                        <textarea name="editedText" rows="15" class="form-control" readonly>
                            <?php
                            echo htmlspecialchars(encryptText($extractedText));
                            ?>
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Convert to DOCX or PDF</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>