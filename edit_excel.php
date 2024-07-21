<?php
session_start();
require 'decrypt_functions.php';

// Define a 16-byte key for AES-128 decryption
$key = $_SESSION['password'] ?? 'default_key_here';  // Ensure key is correctly set

// Use default or session-stored ASCII string
$asciiDecimalsString = $_SESSION['extractedText'] ?? '120 121 123 ...';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editedText'])) {
        $_SESSION['editedText'] = $_POST['editedText'];
        header('Location: convert_to_docx_pdf.php');
        exit;
    }
}

$decryptionResult = decryptText($asciiDecimalsString, $key);
$decryptedData = $decryptionResult['decryptedData'] ?: 'Decryption failed. Please check the key and encrypted data.';
$decryptionSpeed = $decryptionResult['decryptionSpeed'];

include 'pl_edit_excel.php';  // Reference the updated HTML layout filename
?>
