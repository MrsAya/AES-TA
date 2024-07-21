<?php
// Encryption function for AES-256
function encryptText($text)
{
    $key = $_SESSION['password']; // Assume this is securely generated and stored
    if (strlen($key) !== 32) {
        die('Key must be 32 bytes long for AES-256 encryption.');
    }
    $method = 'aes-256-ecb';
    $encryptedData = openssl_encrypt($text, $method, $key, OPENSSL_RAW_DATA);
    $asciiDecimals = array_map('ord', str_split($encryptedData));
    return implode(' ', $asciiDecimals);
}
?>
