<?php
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

// Generate a random key for AES-128
$key = "Tekom Upi Cibiru";
$key1 = "Tekom Upi CibirU";

// Generate a random plaintext of 16 bytes (128 bits)
$plaintext = "Teknik Komputer";
$plaintext1 = "Teknik Komputer";

// Encrypt the plaintext
$ciphertext = openssl_encrypt($plaintext, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

// Encrypt the modified plaintext
$flippedCiphertext = openssl_encrypt($plaintext1, 'AES-128-ECB', $key1, OPENSSL_RAW_DATA);

// Calculate the number of bits that have changed
$diff = strxor($ciphertext, $flippedCiphertext);
$bitChanges = countBits($diff);

// Calculate the percentage of changed bits
$percentageChange = ($bitChanges / (128)) * 100;

echo "Original ciphertext: <br>" . bin2hex($ciphertext) . "<br>";
echo "Modified ciphertext: <br>" . bin2hex($flippedCiphertext) . "<br>";
echo "Number of bits changed: $bitChanges<br>";
echo "Percentage of bits changed: $percentageChange%<br>";
?>
