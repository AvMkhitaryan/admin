<?php
include_once "../connectDb.php";
$value=$_POST["value"];

$select = $conn->query("SELECT `mod`.*, `cat`.`name` AS `cat_name`
FROM `models` AS `mod` 
         LEFT JOIN `categories` AS `cat`
                   ON `mod`.`category_id` = `cat`.`id`
                    WHERE `mod`.`name` LIKE '%$value%'");
$arr = $select->fetchAll(PDO::FETCH_ASSOC);
//
//echo "<pre>";
//var_dump($arr);
echo json_encode($arr);