<?php
function strxor($str1, $str2) {
    $length = min(strlen($str1), strlen($str2));
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $str1[$i] ^ $str2[$i];
    }
    return $result;
}

function countBits($str) {
    $bits = 0;
    foreach (str_split($str) as $char) {
        $bits += substr_count(decbin(ord($char)), '1');
    }
    return $bits;
}

function flipBit($str, $pos) {
    $bytes = str_split($str);
    if ($pos < count($bytes)) {
        $bytes[$pos] ^= chr(0x01);
        $str = implode('', $bytes);
    }
    return $str;
}

function calculateDecryptionSpeed($startTime, $endTime) {
    return ($endTime - $startTime) * 1000; // Return milliseconds
}
?>
