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


function strxor($str1, $str2) {
    $result = '';
    for ($i = 0; $i < strlen($str1); $i++) {
        $result .= $str1[$i] ^ $str2[$i];
    }
    return $result;
}

function countBits($str) {
    $bits = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $bits += substr_count(decbin(ord($str[$i])), '1');
    }
    return $bits;
}

function flipBit($str, $pos) {
    // Flip the first bit of the first character of the string for simplicity
    $str[$pos] = $str[$pos] ^ chr(0x01);
    return $str;
}

// Generate a random key for AES-128
$key = $_SESSION['password'];

// Generate a random plaintext of 16 bytes (128 bits)
$plaintext = $_SESSION['extractedText'];

// Encrypt the plaintext
$ciphertext = openssl_encrypt($plaintext, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

// Modify the plaintext by flipping a bit
$modifiedPlaintext = flipBit($plaintext, 0); // Flip a bit in the first character

// Encrypt the modified plaintext
$flippedCiphertext = openssl_encrypt($modifiedPlaintext, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

// Calculate the number of bits that have changed
$diff = strxor($ciphertext, $flippedCiphertext);
$bitChanges = countBits($diff);

// Calculate the percentage of changed bits
$percentageChange = ($bitChanges / (128)) * 100;

echo "Original ciphertext: <br>" . bin2hex($ciphertext) . "<br>";
echo "Modified ciphertext: <br>" . bin2hex($flippedCiphertext) . "<br>";
echo "Number of bits changed: $bitChanges<br>";
echo "Percentage of bits changed: $percentageChange%<br>";

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