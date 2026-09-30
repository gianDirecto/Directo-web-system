<!-- 
Gian Gabriel T. Directo
BSIT 3A WAM

Web Sys Video - File Upload (spreadsheet file) and maximum of 300mb
-->

<?php
$message = "";

if (isset($_POST['submit'])) {
    $target_dir = "upload/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;
    $fileSize = $_FILES["file"]["size"];
    $uploadOk = 1;

    $fileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $message .= "The file already exists.<br>";
        $uploadOk = 0;
    }

    $maxSize = 300 * 1024 * 1024;
    if ($fileSize > $maxSize) {
        $message .= "The file is too large (max 300MB).<br>";
        $uploadOk = 0;
    }

    $allowed_types = ["xlsx", "xls", "csv"];
    if (!in_array($fileType, $allowed_types)) {
        $message .= "Error: Only XLSX, XLS & CSV files are allowed.<br>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $message .= "The file was not uploaded.<br>";
    } else {
        $fileDestination = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $fileDestination)) {
            $message = "The file " . htmlspecialchars($file_name) . " has been uploaded successfully.";
        } else {
            $message = "There was an error uploading your file.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label>Spreadsheet File Upload</label>
        <input type="file" name="file" required>
        <button type="submit" name="submit">Upload</button>

        <p><?php echo $message; ?></p>
    </form>
</body>
</html>