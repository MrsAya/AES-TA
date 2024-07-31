<?php
require 'vendor/autoload.php';
session_start();

if (isset($_SESSION['editedText'])) {
    $editedText = $_SESSION['editedText'];

    function createSpreadsheetWithCharts($editedText) {
        $asciiDecimals = explode(' ', $editedText);
        $dataChunks = array_chunk($asciiDecimals, 16);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $typeSaham = ['GOTO', 'FREN', 'BBCA', 'TLKM', 'BBRI', 'BMRI', 'ASII', 'UNVR', 'ICBP', 'KLBF', 'ANTM', 'INDF', 'ADRO', 'PTBA', 'SMGR', 'HMSP'];
        $months = [];
        for ($i = 15; $i >= 0; $i--) {
            $months[] = date('M Y', strtotime("-$i months"));
        }

        foreach ($dataChunks as $chunkIndex => $dataChunk) {
            $startRow = 1 + $chunkIndex * 20;
            $data = [['Month', 'Value']];
            foreach ($dataChunk as $index => $value) {
                $data[] = [$months[$index % count($months)], $value];
            }

            $sheet->fromArray($data, NULL, 'A' . $startRow);

            // Change font color to white for all rows including headers
            for ($row = $startRow; $row <= $startRow + 16; $row++) {
                $sheet->getStyle('A' . $row . ':B' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
            }

            // Setting up chart series to reference the cells
            $dataSeriesLabels = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Worksheet!$B$' . $startRow, null, 1),
            ];
            $xAxisTickValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('String', 'Worksheet!$A$' . ($startRow + 1) . ':$A$' . ($startRow + 16), null, 16),
            ];
            $dataSeriesValues = [
                new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues('Number', 'Worksheet!$B$' . ($startRow + 1) . ':$B$' . ($startRow + 16), null, 16),
            ];

            $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_LINECHART,
                \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_STANDARD,
                range(0, count($dataChunk) - 1),
                $dataSeriesLabels,
                $xAxisTickValues,
                $dataSeriesValues
            );

            $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea(null, [$series]);
            $legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, null, false);
            $chartTitle = 'Perkembangan Saham ' . $typeSaham[$chunkIndex % count($typeSaham)];
            $chart = new \PhpOffice\PhpSpreadsheet\Chart\Chart(
                'chart' . $chunkIndex,
                new \PhpOffice\PhpSpreadsheet\Chart\Title($chartTitle),
                $legend,
                $plotArea,
                true,
                0,
                null,
                null
            );

            // Set the position of the chart to start at cell A1
            $chart->setTopLeftPosition('A1');
            $chart->setBottomRightPosition('K15');
            $sheet->addChart($chart);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);
        $outputFileName = 'chart.xlsx';
        $writer->save($outputFileName);

        return $outputFileName;
    }

    $excelFilePath = createSpreadsheetWithCharts($editedText);
    include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Enkripsi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title">Hasil Enkripsi</h5>
            <p class="card-text">File Anda telah berhasil dienkripsi dan dikonversi ke format Excel!</p>
            <a href="<?php echo $excelFilePath; ?>" class="btn btn-primary">Unduh File Enkripsi</a>
        </div>
    </div>
</section>
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
