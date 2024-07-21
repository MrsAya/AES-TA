<?php
// Encryption function for AES-128
function encryptText($text)
{
    $key = $_SESSION['password']; // Assume this is securely generated and stored
    if (strlen($key) !== 16) {
        die('Key must be 16 bytes long for AES-128 encryption.');
    }
    $method = 'aes-128-ecb';
    $encryptedData = openssl_encrypt($text, $method, $key, OPENSSL_RAW_DATA);
    $asciiDecimals = array_map('ord', str_split($encryptedData));
    return implode(' ', $asciiDecimals);
}
?>
