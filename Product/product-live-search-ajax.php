<?php
include_once "../connectDb.php";
$value=$_POST["value"];

$select = $conn->query("SELECT `pro`.*, 
                                    `cat`.`name` AS `cat_name`,
                                      `mod`.`name` AS `mod_name`
                                     FROM `product` AS `pro`
                                     LEFT JOIN `categories` AS `cat`
                                     ON `pro`.`category_id` = `cat`.`id`
                                     LEFT JOIN `models` AS `mod`
                                     ON `pro`.`model_id` = `mod`.`id`  WHERE `pro`.`name` LIKE '%$value%' ");
$arr = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($arr);