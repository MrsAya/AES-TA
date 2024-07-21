<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Extracted Text</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Extracted Text</h2>
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-text"><?php echo $asciiDecimalsString; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Edit Extracted Text</h2>
                <form action="edit_excel.php" method="post" class="mt-4">
                    <div class="form-group">
                        <textarea name="editedText" rows="15" class="form-control" readonly><?php echo htmlspecialchars($decryptedData); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Decryption Speed (ms):</label>
                        <input type="text" class="form-control" value="<?php echo $decryptionSpeed; ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Convert to DOCX or PDF</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
