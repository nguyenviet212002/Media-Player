<?php
session_start(); // Start the session
require_once 'dbcon.php';
require_once '../Library/getid3/getid3.php';


if (isset($_POST['upload_image'])) {

    $targetDirectory = "../uploads/images/";
    $uploadedFile = $_FILES['file']['name'];
    $targetFile = $targetDirectory . basename($uploadedFile);
    

    $getID3 = new getID3();

    // // Analyze the image file
    $fileInfo = $getID3->analyze($_FILES['file']['tmp_name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
    

        $pre_name = $_FILES['file']['name'];
        $status = 1;
        $image_name = $_POST['image_name'];
        $created_at = date("Y-m-d H:i:s");

        $sql_query = "INSERT INTO image (image_name, pre_name, status, created_at) VALUES ('$image_name', '$pre_name', '$status', '$created_at')";
        $conn->query($sql_query);

        $_SESSION['Image_Upload'] = "File uploaded successfully.";
    } else {
        $_SESSION['Image_Upload'] = "Error uploading the file.";
    }

    // Redirect to the current page to display the message
    header("Location: ../upload-image.php");
    exit;
}
