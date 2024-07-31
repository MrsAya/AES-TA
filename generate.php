<?php
require_once 'vendor/autoload.php'; // Pastikan Anda sudah menginstal PhpWord melalui Composer

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Membaca file teks dengan nama-nama
$filename = "Random_Names.txt";
$names = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Directory untuk menyimpan file docx
if (!file_exists('docx_files')) {
    mkdir('docx_files', 0777, true);
}

foreach ($names as $name) {
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $section->addText($name);

    $docxName = 'docx_files/' . $name . '.docx';
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($docxName);
}

echo "Semua file docx telah dibuat!";
?>
