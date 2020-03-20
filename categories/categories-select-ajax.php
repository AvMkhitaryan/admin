<?php

include_once "../connectDb.php";

$select = $conn->query("SELECT * FROM `categories` ORDER BY id DESC");
$arr = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($arr);
