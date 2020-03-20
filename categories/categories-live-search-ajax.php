<?php
include_once "../connectDb.php";
$value=$_POST["value"];

$select = $conn->query("SELECT * FROM `categories` WHERE `name` LIKE '%$value%' ");
$arr = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($arr);