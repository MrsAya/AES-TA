<?php
// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Rest of your PHP code
?>

<?php
require 'vendor/autoload.php'; // Autoload the necessary libraries

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;

session_start();

if (isset($_SESSION['editedText'])) {
    $editedText = $_SESSION['editedText'];

    // Convert newlines to HTML line breaks for the PDF conversion
    $editedTextHtml = nl2br($editedText);

    // Define the directory to save the file
    $directory = 'converted';

    // Check if the directory exists, if not create it
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Generate a unique file name using timestamp
    $timestamp = date('YmdHis');

    // Save the edited text as a DOCX file
    $docxFileName = "converted_text_$timestamp.docx";
    $docxFilePath = $directory . '/' . $docxFileName;

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $textLines = explode("\n", $editedText);
    
    foreach ($textLines as $line) {
        $textRun = $section->addTextRun();
        $textRun->addText($line);
        $textRun->addTextBreak();
    }

    // Save the PhpWord object to a DOCX file
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($docxFilePath);

    // Generate a PDF file using Dompdf
    $pdfFileName = "converted_text_$timestamp.pdf";
    $pdfFilePath = $directory . '/' . $pdfFileName;

    // HTML template for PDF conversion
    $htmlContent = '<html><head><style>' .
        'body { font-family: Arial, sans-serif; }' .
        '</style></head><body><div>' . $editedTextHtml . '</div></body></html>';

    // Create a Dompdf instance
    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output PDF content to file
    file_put_contents($pdfFilePath, $dompdf->output());

    // Provide download links for the DOCX and PDF files
    include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversion Result</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Result Section -->
<section class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title">Conversion Result</h5>
            <p class="card-text">Your text has been successfully converted!</p>
            <a href="<?php echo $docxFilePath; ?>" class="btn btn-primary mr-3">Download DOCX File</a>
            <a href="<?php echo $pdfFilePath; ?>" class="btn btn-success">Download PDF File</a>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
} else {
    echo 'No edited text found in the session.';
}
?>
