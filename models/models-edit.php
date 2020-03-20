<?php
session_start();
include_once "../connectDb.php";

if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true){

    $id = $_GET["id"];
    $name = $_GET["name"];
    $cat_name = $_GET["cat_name"];

    $select = $conn->query("SELECT * FROM `categories`");
    $arr = $select->fetchAll(PDO::FETCH_ASSOC);
//    echo "<pre>";
//    var_dump($arr);
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
    <div class="d-flex justify-content-center">
        <form action="">
        <div style="margin-top:50px">
            <h6>EDIT 'Models' information</h6>
        <label for="name">Name
            <input type="text" value="<?= $name ?>" id="name">
        </label>
            <div class="d-flex">
                <h6>Categories</h6>
                <select id="select" data-id="<?= $cat_name?>">
                    <option>---</option>
                    <?php foreach ($arr as $value ){?>
                        <option <?php if ($cat_name==$value["name"]){
                            echo 'selected=\"selected\"';
                        } ?> value="<?=$value["id"];?>"><?=$value["name"];?></option>
                    <?php } ?>
                </select>
                </form>
            </div>
    <div>
        <button type="button" onclick="goToTable(<?= $id ?>)" class="btn btn-success">Edit</button>
        <a href="models.php" class="btn btn-success">Go Back</a>
    </div>
        </div>
    </div>
    <script>

       function goToTable(editID) {
            let editName = $("#name").val();
            let optt=$("#select").val();

            $.ajax({
                url: 'models-edit-ajax.php',
                type: 'post',
                dataType: 'json',
                data: {id: editID, NewNAme: editName, opptId:optt},
                success: function (data) {
                    if (data) {
                        window.location = "models.php";
                    }
                }
            });
        }
    </script>

    </body>
    </html>
<?php
}else{
    header("Location:login.php");
}