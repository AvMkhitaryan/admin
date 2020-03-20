<?php
session_start();
include_once "../connectDb.php";
$id = $_GET["id"];
$name = $_GET["name"];
if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/jquery-3.4.1.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <h6>Categories Edit Information</h6>
    <label for="name">Name</label>
    <input type="text" value="<?= $name ?>" id="name">
    <button type="button" onclick="goToTable(<?= $id ?>)" class="btn btn-success">OK</button>
    <a type="button" href="categories.php" class="btn btn-success">Go Back</a>
</div>
</body>
</html>
<form>

    <?php
    } else {
        header("Location:login.php");
    }
    ?>
    <script>
        function goToTable(editID) {
            console.log(editID);
            let editName = $("#name").val();
            $.ajax({
                url: 'categories-edit-ajax.php',
                type: 'post',
                dataType: 'json',
                data: {id: editID, NewNAme: editName},
                success: function (data) {
                    if (data) {
                        window.location = "categories.php";
                    }
                }
            });
        }
    </script>
