<?php
session_start();

require 'vendor/autoload.php'; // Autoload the necessary libraries

use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Check if the uploaded file is a DOCX or PDF
        $allowedTypes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        $fileType = $_FILES['file']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            $extractedText = '';

            // Extract text from PDF
            if ($fileType === 'application/pdf') {
                $parser = new Parser();
                $pdf = $parser->parseFile($_FILES['file']['tmp_name']);
                $extractedText = $pdf->getText();
            } 

            // Extract text from DOCX
            elseif ($fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $phpWord = IOFactory::load($_FILES['file']['tmp_name']);
                $sections = $phpWord->getSections();
                foreach ($sections as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        if (method_exists($element, 'getText')) {
                            $extractedText .= $element->getText() . "\n";
                        }
                    }
                }
            }

            // Store the extracted text in session
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['extractedText'] = $extractedText;

            // Redirect to edit page
            header('Location: edit_docx_pdf.php');
            exit;
        } else {
            echo 'Only DOCX and PDF files are allowed.';
        }
    } else {
        echo 'Error uploading file.';
    }
} else {
    echo 'Invalid request method.';
}
?>