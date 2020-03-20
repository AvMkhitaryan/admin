<?php
session_start();

if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true){
    include_once "../connectDb.php";

    $select1 = $conn->query("SELECT `pro`.*, 
                                    `cat`.`name` AS `cat_name`,
                                      `mod`.`name` AS `mod_name`
                                     FROM `product` AS `pro`
                                     LEFT JOIN `categories` AS `cat`
                                     ON `pro`.`category_id` = `cat`.`id`
                                     LEFT JOIN `models` AS `mod`
                                     ON `pro`.`model_id` = `mod`.`id`  
                                     ORDER BY id DESC");
    $select1->execute();
    $arr1 = $select1->fetchAll(PDO::FETCH_ASSOC);


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
                <a class="btn btn-warning" href="../categories/categories.php">Categories</a>
                <a class="btn btn-success" href="../models/models.php">Models</a>
                <a class="btn btn-primary" HREF="../Product/product.php">Product</a>
            </div>
            <div id="" class="col-10 d-flex">
                <div style="width: 100%">
                    <table class="table table-dark table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>Category_id</th>
                            <th>model_id</th>
                            <th>Image_path</th>
                            <th>isNew</th>
                            <th>Desc_info</th>
                            <th>price</th>
                            <th>create_time</th>
                            <th>update_time</th>
                            <th><input id="liveSerach" type="text" name="serach" placeholder="Serach For Name"></th>
                        </tr>
                        </thead>
                        <tbody id="appenTbody">
                       <?php foreach ($arr1 as $value){?>
                            <tr>
                                <td><?=$value["id"] ?></td>
                                <td><?=$value["name"] ?></td>
                                <td><?=$value["cat_name"] ?></td>
                                <td><?=$value["mod_name"] ?></td>
                                <td><?=$value["img_path"] ?></td>
                                <td><?=$value["is_new"] ?></td>
                                <td><?=$value["desc_info"] ?></td>
                                <td><?=$value["price"] ?></td>
                                <td><?=$value["create_time"] ?></td>
                                <td><?=$value["update_time"] ?></td>
                                <td>
                                    <a href="product-edit.php?id=<?=$value["id"]?>&name=<?=$value["name"]?>&category_id=<?=$value["category_id"]?>&model_id=<?=$value["model_id"]?>&img_path=<?=$value["img_path"]?>&is_new=<?=$value["is_new"]?>&desc_info=<?=$value["desc_info"]?>&price=<?=$value["price"]?>"
                                    class="btn btn-success"><i class="fa fa-pencil" style="color: white" aria-hidden="true"></i></a>
                                    <button onclick="delProd(<?=$value["id"] ?>)" class="btn btn-danger"><i class="fa fa-trash-o" style="color: white" aria-hidden="true"></i></button>
                                </td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-1" style="">
                <a href="../Logout.php" class="btn btn-danger exit">EXIT</a>
                <a href="product-insert.php" class="btn btn-primary">New</a>
            </div>
        </div>
    </div>
    <script>

        $("#liveSerach").keyup(function() {
            let val= $("#liveSerach").val();
            $.ajax({
                url: 'product-live-search-ajax.php',
                type: 'POST',
                dataType: 'json',
                data: {value: val},
                success: function (data) {
                    $("#appenTbody").children().remove();
                    data.forEach((i) => (
                        $("#appenTbody").append(` <tr>
                                <td>${i.id}</td>
                                <td>${i.name}</td>
                                <td>${i.cat_name}</td>
                                <td>${i.mod_name}</td>
                                <td>${i.img_path}</td>
                                <td>${i.is_new}</td>
                                <td>${i.desc_info}</td>
                                <td>${i.price}</td>
                                <td>${i.create_time}</td>
                                <td>${i.update_time}</td>
                                <td>
                                    <a href="product-edit.php?id=${i.id}&name=${i.name}&category_id=${i.category_id}&model_id=${i.model_id}&img_path=${i.img_path}&is_new=${i.is_new}&desc_info=${i.desc_info}&price=${i.price}"
                                    class="btn btn-success"><i class="fa fa-pencil" style="color: white" aria-hidden="true"></i></a>
                                    <button onclick="delProd(${i.id})" class="btn btn-danger"><i class="fa fa-trash-o" style="color: white" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                     `)
                    ))
                }
            })
        });


        function delProd(arg) {
        let del = confirm("Delete?");
        if (del === true) {
            $.ajax({
                url: 'product-delete.php',
                type: 'POST',
                dataType: 'json',
                data: {a: arg},
                success: function (data) {
                    console.log(data);
                    if (data===true) {
                        window.location = "product.php";
                    }
                }
            })
        }
        }
    </script>


    </body>
    </html>
<?php
}else{
    header("Location:login.php");
}
?>