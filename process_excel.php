<?php
session_start();

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

function extractValuesFromUploadedExcel($file) {
    // Check if the file is an Excel file
    $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (!in_array($file['type'], $allowedTypes)) {
        return 'Only Excel files are allowed.';
    }

    // Load the Excel file
    $reader = IOFactory::createReader('Xlsx');
    $spreadsheet = $reader->load($file['tmp_name']);
    
    // Select the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();
    
    // Get the highest row number with data
    $highestRow = $worksheet->getHighestRow();
    
    // Initialize an array to store the numerical values
    $values = [];
    
    // Loop through each row in the worksheet (start from row 2 to skip headers)
    for ($row = 2; $row <= $highestRow; $row++) {
        // Get the value of the second column (B)
        $value = $worksheet->getCell('B' . $row)->getValue();
        
        // Add the numerical value to the array, excluding "Value" string and empty values
        if ($value !== "Value" && isset($value)) {
            $values[] = $value;
        }
    }
    
    // Convert the array to a string of values separated by commas
    $extractedText = implode(' ', $values);
    
    // Store the extracted text in session
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['extractedText'] = $extractedText;
    
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $result = extractValuesFromUploadedExcel($_FILES['file']);
        if ($result === true) {
            // Redirect to edit page
            header('Location: edit_excel.php');
            exit;
        } else {
            echo $result; // Display error message
        }
    } else {
        echo 'Error uploading file.';
    }
} else {
    echo 'Invalid request method.';
}
?>
