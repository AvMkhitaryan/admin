<?php
session_start();
include_once "../connectDb.php";

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
    <div class="conatienr">

        <form action="" method="POST" style="margin-left: 50px">
            <h6>Crategore insert</h6>
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
            <input type="submit" class="btn btn-success" name="click" value="Create">
            <a href="categories.php" class="btn btn-success">Go Back</a>
        </form>
    </div>

    </body>
    </html>
<?php
    if (isset($_POST["click"]) && $_POST["click"] == 0) {
        $newName=$_POST["name"];
        $sql = "INSERT INTO `categories` (name, create_time,update_time)VALUES ('$newName', now(),now())";
        $conn->exec($sql);

        header("Location:categories.php");
    }

}else{
    header("Location:login.php");
}
