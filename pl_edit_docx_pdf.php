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
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($plaintext)); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Edit Extracted Text</h2>
                <form action="edit_docx_pdf.php" method="post" class="mt-4">
                    <div class="form-group">
                        <textarea name="editedText" rows="15" class="form-control" readonly><?php echo htmlspecialchars(encryptText($plaintext)); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Convert to DOCX or PDF</button>
                </form>
            </div>
        </div>
        <div class="mt-4">
            <label for="originalCiphertext">Original Ciphertext:</label>
            <textarea id="originalCiphertext" class="form-control" rows="1" readonly><?= bin2hex($ciphertext) ?></textarea>
            <label for="modifiedCiphertext">Modified Ciphertext:</label>
            <textarea id="modifiedCiphertext" class="form-control" rows="1" readonly><?= bin2hex($flippedCiphertext) ?></textarea>
            <label for="bitChanges">Number of bits changed:</label>
            <input type="text" id="bitChanges" class="form-control" value="<?= $bitChanges ?>" readonly>
            <label for="percentageChange">Percentage of bits changed:</label>
            <input type="text" id="percentageChange" class="form-control" value="<?= $percentageChange ?>%" readonly>
            <label for="encryptionSpeed">Encryption Speed (ms):</label>
            <input type="text" id="encryptionSpeed" class="form-control" value="<?= $encryptionSpeed ?>" readonly>
        </div>
    </div>
</body>
</html>
