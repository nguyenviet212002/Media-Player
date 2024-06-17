<?php
require_once 'dbcon.php';

$query = "DELETE FROM `music` WHERE mid = " . $_GET['id'];
$conn->query($query);

header("Location: ../music.php");
exit;
