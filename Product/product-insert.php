<?php

session_start();
include_once "../connectDb.php";


if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true){
    $select1 = $conn->query("SELECT * FROM `categories`");
    $arr1 = $select1->fetchAll(PDO::FETCH_ASSOC);

    $select2 = $conn->query("SELECT * FROM `models`");
    $arr2 = $select2->fetchAll(PDO::FETCH_ASSOC);


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
    <div class="container-fluid">
        <div class="row">
            <div class="col-1">
                <h4>Product</h4>
                <a class="btn btn-warning" href="../categories.php">Categories</a>
                <a class="btn btn-success" href="../models/models.php">Models</a>
                <a class="btn btn-primary" HREF="../Product/product.php">Product</a>
            </div>
            <div id="" class="col-10">
                <h5>insert information to 'Producte' table</h5>
                <div style="width:100%" class="d-flex justify-content-center">
                    <form method="post" action="" enctype='multipart/form-data'>
                        <div>
                        <label for="name">Name
                        <input id="name" type="text" name="name">
                        </label>
                        </div>
                        <div>
                        <label for="category">Category_Name
                            <select name="category" id="category">
                                <option selected="selected">----</option>
                                <?php
                                foreach ($arr1 as $value) {
                                    ?>
                                    <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        </div>
                        <div>
                            <label for="model">Model_Name
                                <select name="model" id="model">
                                    <option selected="selected">----</option>
                                    <?php
                                    foreach ($arr2 as $value) {
                                        ?>
                                        <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div>
                            <label for="image">Image
                                <input type="file" id="image" name="image">
                            </label>
                        </div>
                        <div>
                            <label for="new">New Production ?
                                <select name="new" id="new">
                                    <option value="NEW" selected="selected">New</option>
                                    <option value="notNew">Not New</option>
                                </select>
                            </label>
                        </div>
                        <div>
                            <label for="text">Desc Info
                            <textarea class="form-control" id="text" rows="3" name="text"></textarea>
                            </label>
                        </div>
                        <div>
                            <label for="price">Price
                                <input type="text" id="price" name="price">
                            </label>
                        </div>
                        <div class="d-flex">
                            <input type="submit" name="click" class="btn btn-success"  value="insert Info">
                            <a href="product.php" class="btn btn-success"> GO Product</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-1">
                <a href="../Logout.php" class="btn btn-danger exit">EXIT</a>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST["click"]) && $_POST["click"] == 0) {
        $dir="image";
        if ($_FILES && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $name = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            move_uploaded_file($tmp, "$dir/$name");
        }
        $name=$_POST["name"];
        $category=$_POST["category"];
        $model=$_POST["model"];
        $new=$_POST["new"];
        $image=$_FILES["image"]["name"];
        $text=$_POST["text"];
        $price=$_POST["price"];

        $sql = "INSERT INTO `product` (name,category_id, model_id,img_path, is_new ,desc_info, price, create_time,update_time)
                               VALUES ('$name','$category','$model','$image','$new','$text','$price', now(),now())";
        $let=$conn->exec($sql);

    }
}else{
    header("Location:login.php");
}?>

</body>
</html>