<?php
require_once 'dbcon.php';

$query = "DELETE FROM `video` WHERE vid = " . $_GET['id'];
$conn->query($query);

header("Location: ../video.php");
exit;
