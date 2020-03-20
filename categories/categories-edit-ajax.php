<?php
include_once "../connectDb.php";
$id=$_POST["id"];
$editNAme=$_POST["NewNAme"];
$sql = "UPDATE `categories` SET `name`='$editNAme',`update_time`=now() WHERE id=$id";

$stmt = $conn->prepare($sql);

$stmt->execute();
echo 1;