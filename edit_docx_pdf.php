<?php
session_start();

require 'vendor/autoload.php';
require 'encryption_functions.php';
require 'utility_functions.php';

// Check and process POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editedText'])) {
    $editedText = encryptText($_SESSION['extractedText']);
    $_SESSION['editedText'] = $editedText;
    header('Location: convert_to_excel.php');
    exit;
}

// Redirect if no text is extracted
if (!isset($_SESSION['extractedText'])) {
    header('Location: index.php');
    exit;
}

$startTime = microtime(true); // Start timing before encryption

// Encryption logic goes here
$plaintext = $_SESSION['extractedText'] ?? 'Sample plaintext for demonstration.';
$key = $_SESSION['password'] ?? 'your_32_byte_long_secure_key_here';

$ciphertext = openssl_encrypt($plaintext, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
$modifiedPlaintext = flipBit($plaintext, 0);
$flippedCiphertext = openssl_encrypt($modifiedPlaintext, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

$endTime = microtime(true); // End timing after encryption
$encryptionSpeed = ($endTime - $startTime) * 1000; // Calculate duration in milliseconds

$diff = strxor($ciphertext, $flippedCiphertext);
$bitChanges = countBits($diff);
$percentageChange = ($bitChanges / 128) * 100;


$editedText = encryptText($_SESSION['extractedText']);
$_SESSION['editedText'] = $editedText;
header('Location: convert_to_excel.php');
exit;

include 'pl_edit_docx_pdf.php';  // Include the HTML layout file
?>
