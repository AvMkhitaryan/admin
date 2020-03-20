<?php
session_start();
include_once "connectDb.php";
$name = $_POST["name"];
$pass = $_POST["pass"];

$chek = $_POST["chekit"];
$cook_value = "";

if (!empty($_POST["name"] && $_POST["pass"])) {
    $select = $conn->query("SELECT id, login, password FROM `users`");
    $arr = $select->fetchAll(PDO::FETCH_ASSOC);
    $n = $arr[0]["login"];
    $p = $arr[0]["password"];
    $id = $arr[0]["id"];
    if ($name == $n) {
        if ($pass == $p) {
            $_SESSION["name"] = $n;
            $_SESSION["id"] = $id;
            $_SESSION["auth"] = true;
            if ($chek=="on"){
                for ($i = 0; $i <= 35; $i++) {
                    if ($i % 2 === 0) {
                        $cook_value .= chr(rand(97, 122));
                    } else {
                        $cook_value .= mt_rand(0, 100);
                    }
                }
                $upadte = "UPDATE `users` SET cookie_key='$cook_value' WHERE id='$id' ";
                $stmt = $conn->prepare($upadte);
                $stmt->execute();
                setcookie('cook_key',$cook_value,time()+(60*60),"/");
                setcookie('login',$n,time()+(60*60),"/");
            };
            header("Location:account.php");
        } else {
            $_SESSION["erorr_password"] = "Sxal passsword";
            header("Location:login.php");
        }
    } else {
        $_SESSION["error_login"] = "Sxal Login";
        header("Location:login.php");
    }
} else {
    header("Location: login.php");
}