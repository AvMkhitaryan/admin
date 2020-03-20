<?php
include_once "../connectDb.php";
$delID = $_POST["a"];
if (isset($delID)){
    echo "true";
}
$sql = $conn->prepare("DELETE FROM `models` WHERE `id`='$delID'");
$sql->execute();