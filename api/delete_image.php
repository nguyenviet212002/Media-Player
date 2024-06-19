<?php
require_once 'dbcon.php';

$query = "DELETE FROM `image` WHERE id = " . $_GET['id'];
$conn->query($query);

header("Location: ../image.php");
exit;
