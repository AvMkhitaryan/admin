<?php
include "../connectDb.php";
$id=$_POST["id"];
$editNAme=$_POST["NewNAme"];
$opptId=$_POST["opptId"];
if (!empty($opptId)){
    echo "true";
}
$sql = "UPDATE `models` SET `name`='$editNAme',`category_id`='$opptId' WHERE `id`='$id'";

$stmt = $conn->prepare($sql);

$stmt->execute();
