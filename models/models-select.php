<?php
session_start();
include "../connectDb.php";
$select = $conn->query("SELECT * FROM `categories`");
$arr = $select->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="d-flex justify-content-center" style="margin-top: 50px">
        <form action="">
            <h6> Create New TOX </h6>
            <input id="input" type="text" value="">
            <select name="" id="createID">
                <option selected="selected">----</option>
                <?php
                foreach ($arr as $value) {
                    ?>
                    <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                    <?php
                }
                ?>
            </select>
            <a type="button" class="btn btn-success" onclick="fun()">OK</a>
        </form>
    </div>

    </body>
    </html>
    <?php
} else {
    header("Location:login.php");
}
?>
<script>
    function fun() {
        let inpuVal = $("#input").val();
        let selVal = $("#createID").val();
    console.log(inpuVal);
        $.ajax({
            url: 'models-select-ajax.php',
            type: 'post',
            dataType: 'json',
            data: {arg1: inpuVal, arg2: selVal},
            success: function (data) {
                if (data===true){
                    window.location = "models.php";
                }
            }
        })
    }
</script>
