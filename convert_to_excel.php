<?php

require 'vendor/autoload.php';

session_start();

// Get edited text from session variable
if(isset($_SESSION['editedText'])) {
    $editedText = $_SESSION['editedText'];

    function createSpreadsheetWithCharts($editedText) {
        // Convert ASCII decimals string to array of integers
        $asciiDecimals = explode(' ', $editedText);

        // Split data into chunks of 16 values each
        $dataChunks = array_chunk($asciiDecimals, 16);

        // Create a new spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Initialize chart counter
        $chartCounter = 1;

        // Define the letters and numbers to use (A to Z, 0 to 9)
        
        $typeSaham[] = ['GOTO', 'FREN', 'BBCA', 'TLKM', 'BBRI',
        'BMRI', 'ASII', 'UNVR', 'ICBP', 'KLBF', 'ANTM', 'INDF',
        'ADRO', 'PTBA', 'SMGR', 'HMSP'];
        $lettersNumbers = [
            'AALI', 'ADRO', 'BBCA', 'BBRI', 'BBNI', 'BMRI', 'INCO', 'INKP', 'INTP', 'ISAT', 
            'KLBF', 'LSIP', 'LPKR', 'MCAS', 'SMGR', 'TLKM', 'UNTR', 'UNVR', 'WSBP', 'WSKT',
            // Tambahkan lebih banyak nama saham sesuai kebutuhan
        ];
        
        // Loop through each data chunk
        foreach ($dataChunks as $dataChunk) {
            // Initialize an array to hold the data for this chunk
            $data = [];
        
            // Add the first row
            $data[] = ['Type', 'Value'];
        
            // Loop through the ASCII decimals in this chunk
            foreach ($dataChunk as $index => $asciiDecimal) {
                // Calculate letter/number for the month
                $letter = $lettersNumbers[$index % count($lettersNumbers)];
        
                // Add to data array
                $data[] = [$letter, $asciiDecimal];
            }
        
            // Add data to the worksheet
            $sheet->fromArray($data, NULL, 'A' . (1 + ($chartCounter - 1) * 20));
        
            // Define the data series
            $dataSeriesLabels = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Worksheet!$B$'.(1 + ($chartCounter - 1) * 20), null, 1), // Chart title
            ];
        
            $xAxisTickValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Worksheet!$A$'.(2 + ($chartCounter - 1) * 20).':$A$'.(17 + ($chartCounter - 1) * 20), null, 16), // X-axis labels
            ];
        
            $dataSeriesValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('Number', 'Worksheet!$B$'.(2 + ($chartCounter - 1) * 20).':$B$'.(17 + ($chartCounter - 1) * 20), null, 16), // Data values
            ];
        
            // Build the data series
            $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_LINECHART, // Chart type
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_STANDARD, // Grouping
                range(1, 16), // Plot order (skip the first row)
                $dataSeriesLabels, // Series labels
                $xAxisTickValues, // X-axis labels
                $dataSeriesValues // Data values
            );
        
            // Set up a layout
            $layout = new \PhpOffice\PhpSpreadsheet\Chart\Layout();
        
            // Create the plot area
            $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea($layout, [$series]);
        
            // Set the chart legend
            $legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, null, false);
        
            // Create the chart
            $title = new \PhpOffice\PhpSpreadsheet\Chart\Title('Perkembangan Saham bulan ' . $chartCounter);
            $chart = new \PhpOffice\PhpSpreadsheet\Chart\Chart(
                'chart' . $chartCounter, // Chart name
                $title, // Title
                $legend, // Legend
                $plotArea, // Plot area
                true, // Plot visible only
                0, // Display blanks as
                null, // X-axis labels
                null // Y-axis labels
            );
        
            // Set the position where the chart should appear in the worksheet
            $chart->setTopLeftPosition('D' . (1 + ($chartCounter - 1) * 20));
            $chart->setBottomRightPosition('L' . (15 + ($chartCounter - 1) * 20));
        
            // Add the chart to the worksheet
            $sheet->addChart($chart);
        
            // Increment chart counter
            $chartCounter++;
        }
        

        // Write the spreadsheet to a file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setIncludeCharts(true); // Important to include charts
        $outputFileName = 'chart.xlsx';
        $writer->save($outputFileName);

        // Return the file path
        return $outputFileName;
    }

    // Call the function to create the Excel file
    $excelFilePath = createSpreadsheetWithCharts($editedText);

    // Provide download link for the Excel file
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
            <a href="<?php echo $excelFilePath; ?>" class="btn btn-primary">Download Excel File</a>
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
