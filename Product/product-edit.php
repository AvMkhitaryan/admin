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
        <style>
            .container {
                position: relative;
                width: 50%;
            }

            .image {
                opacity: 1;
                display: block;
                width: 100%;
                height: auto;
                transition: .5s ease;
                backface-visibility: hidden;
            }

            .middle {
                transition: .5s ease;
                opacity: 0;
                position: absolute;
                top: 36%;
                left: 50%;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                text-align: center;
            }

            .container:hover .image {
                opacity: 0.3;
            }

            .container:hover .middle {
                opacity: 1;
            }

            .text {
                background-color: rgba(36, 84, 39, 0.51);
                color: white;
                font-size: 16px;
                padding: 16px 32px;
            }
        </style>
    </head>
    <body>
    <?php
    $id=$_GET["id"];
    $name=$_GET["name"];
    $category=$_GET["category_id"];
    $model=$_GET["model_id"];
    $img=$_GET["img_path"];
    $is_new=$_GET["is_new"];
    $desc_info=$_GET["desc_info"];
    $price=$_GET["price"];

//    echo $id." ".$name." ".$category." ".$model." ".$img." ".$is_new." ".$desc_info." ".$price ;
    ?>
    <div id="tt" data-id="<?= $desc_info ?>"></div>
    <div style="width:100%" class="d-flex justify-content-center">
        <form method="post" action="" enctype='multipart/form-data'>
            <div>
                <label for="name">Name
                    <input id="name" type="text" name="name" value="<?=  $name?>">
                </label>
            </div>
            <div>
                <label for="category">Category_Name
                    <select name="category" id="category">
                        <option selected="selected">----</option>
                        <?php
                        foreach ($arr1 as $value) {
                            ?>
                            <option <?php if ($category==$value["id"]){
                                echo 'selected=\"selected\"';
                            } ?> value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
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
                            <option <?php if ($model==$value["id"]){
                                echo 'selected=\"selected\"';
                            } ?> value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </label>
            </div>
            <div id="imgPath" data-id="<?=$id ?>" style="width:250px;">
                <div>image path "<?= $img ?>"</div>
                <input type="file" name="image">
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
                    <input type="text" id="price" name="price" value="<?= $price ?>" >
                </label>
            </div>
            <div class="d-flex">
                <input type="submit" name="click" class="btn btn-success"  value="Edit">
                <a style="margin-left: 50px" href="product.php" class="btn btn-success">GO Product </a>
            </div>
        </form>
    </div>
    <script>
        let text =$("#tt").attr('data-id');
        $("#text").append(text);


    </script>


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

        if (empty($image)){
            $image=$img;
        }

        $sql = "UPDATE `product` SET name='$name', category_id='$category',model_id='$model',img_path='$image',is_new='$new',desc_info='$text',price='$price', update_time='now()' WHERE id='$id'";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        header("Location:product.php");
    }

    ?>

    </body>
    </html>
<?php
}else{
    header("Location:login.php");
}