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
        $chartCounter = 0;
    
        // Define stock types for charts
        $typeSaham = ['GOTO', 'FREN', 'BBCA', 'TLKM', 'BBRI',
        'BMRI', 'ASII', 'UNVR', 'ICBP', 'KLBF', 'ANTM', 'INDF',
        'ADRO', 'PTBA', 'SMGR', 'HMSP'];
    
        // Calculate months for labels (16 months past from this month)
        $months = [];
        for ($i = 15; $i >= 0; $i--) {
            $months[] = date('M Y', strtotime("-$i months"));
        }
    
        // Loop through each data chunk
        foreach ($dataChunks as $dataChunk) {
            // Initialize an array to hold the data for this chunk
            $data = [];
        
            // Add the first row
            $data[] = ['Type', 'Value'];
        
            // Loop through the ASCII decimals in this chunk
            foreach ($dataChunk as $index => $asciiDecimal) {
                // Use month for the label
                $month = $months[$index % count($months)];
        
                // Add to data array
                $data[] = [$month, $asciiDecimal];
            }
        
            // Add data to the worksheet
            $sheet->fromArray($data, NULL, 'A' . (1 + $chartCounter * 20));
        
            // Define the data series
            $dataSeriesLabels = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Worksheet!$B$'.(1 + $chartCounter * 20), null, 1),
            ];
        
            $xAxisTickValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Worksheet!$A$'.(2 + $chartCounter * 20).':$A$'.(17 + $chartCounter * 20), null, 16),
            ];
        
            $dataSeriesValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('Number', 'Worksheet!$B$'.(2 + $chartCounter * 20).':$B$'.(17 + $chartCounter * 20), null, 16),
            ];
        
            // Build the data series
            $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_LINECHART,
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_STANDARD,
                range(1, count($dataChunk)),
                $dataSeriesLabels,
                $xAxisTickValues,
                $dataSeriesValues
            );
        
            // Set up a layout
            $layout = new \PhpOffice\PhpSpreadsheet\Chart\Layout();
        
            // Create the plot area
            $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea($layout, [$series]);
        
            // Set the chart legend
            $legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, null, false);
        
            // Create the chart
            $title = new \PhpOffice\PhpSpreadsheet\Chart\Title('Perkembangan Saham ' . $typeSaham[$chartCounter % count($typeSaham)]);
            $chart = new \PhpOffice\PhpSpreadsheet\Chart\Chart(
                'chart' . $chartCounter,
                $title,
                $legend,
                $plotArea,
                true,
                0,
                null,
                null
            );
        
            // Set the position where the chart should appear in the worksheet
            $chart->setTopLeftPosition('D' . (1 + $chartCounter * 20));
            $chart->setBottomRightPosition('L' . (15 + $chartCounter * 20));
        
            // Add the chart to the worksheet
            $sheet->addChart($chart);
        
            // Increment chart counter
            $chartCounter++;
        }

    
        // Write the spreadsheet to a file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);
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
