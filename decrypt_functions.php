<?php
// Include utility functions for timing
require 'utility_functions.php';

function decryptText($asciiDecimalsString, $key) {
    $startTime = microtime(true);

    // Convert the ASCII decimals back to binary data
    $asciiArray = explode(' ', $asciiDecimalsString);
    $encryptedDataFromAscii = '';
    foreach ($asciiArray as $asciiDecimal) {
        $encryptedDataFromAscii .= chr($asciiDecimal);
    }

    $method = 'aes-128-ecb';
    $decryptedData = openssl_decrypt($encryptedDataFromAscii, $method, $key, OPENSSL_RAW_DATA);

    $endTime = microtime(true);
    $decryptionSpeed = calculateDecryptionSpeed($startTime, $endTime);

    return [
        'decryptedData' => $decryptedData,
        'decryptionSpeed' => $decryptionSpeed
    ];
}
?>
