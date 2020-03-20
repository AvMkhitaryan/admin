<?php
include_once "../connectDb.php";
session_start();
$limit = 10;

if (isset($_POST["page"])) {
    $page = $_POST["page"];
} else {
    $page=1;
};

$start_from = ($page-1) * $limit;

$models_category = $conn->query("SELECT `mod`.*, `cat`.`name` AS `cat_name`
FROM `models` AS `mod` 
         LEFT JOIN `categories` AS `cat`
                   ON `mod`.`category_id` = `cat`.`id`
                    ORDER BY id DESC 
                    LIMIT $start_from , $limit ;");

$models_category->execute();
$arrModels = $models_category->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($arrModels);

