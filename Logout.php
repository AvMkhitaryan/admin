<?php
session_start();
include_once "connectDb.php";
$empt = null;
$id = $_SESSION["id"];

$up = "UPDATE `users` SET cookie_key='$empt' WHERE id= $id";

$stmt = $conn->prepare($up);
$stmt->execute();

setcookie('cook_key', $cook_value, time() - 3600, '/');


unset($_SESSION["name"]);

unset($_SESSION["password"]);

header("Location:login.php");
