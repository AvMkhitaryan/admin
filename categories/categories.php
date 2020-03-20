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
    <div class="container-fluid">
        <div class="row">
            <div class="col-1">
                <h4>Categorias</h4>
                <a class="btn btn-warning" id="cat" href="../categories/categories.php">categories</a>
                <a class="btn btn-success" href="../models/models.php">Models</a>
                <a class="btn btn-primary" href="../Product/product.php">Product</a>
            </div>
            <div id="center-section" class="col-10 d-flex">

                <div class="d-flex">

                    <table class="table table-dark">
                        <thead >
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NAME</th>
                            <th scope="col">CREATE-TIME</th>
                            <th scope="col">UPDATE-TIME</th>
                            <th scope="col"><input id="liveSerach" type="text" name="serach" placeholder="Serach For Name"></th>
                        </tr>
                        </thead>
                        <tbody id="tab">


                        </tbody>
                    </table>
                    <div><a href="categories-insert.php" class="btn btn-success" type="button">Insert</a></div>
                </div>
                <div style="margin-left: 150px;height: 39px;">

                </div>

                <div id="input-update-form">

                </div>
                <div id="input-form">

                </div>
                <div id="cl_cat" href="../categories/categories.php"></div>

            </div>
            <div class="col-1">
                <a href="../Logout.php" class="btn btn-danger exit">EXIT</a>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} else {
    header("Location:../login.php");
}
?>

<script>


        $.ajax({
            url: 'categories-select-ajax.php',
            type: 'post',
            dataType: 'json',
            success: function fun(data) {
                data.forEach((i, k) => (
                    $("#tab").append(`
                            <tr id="trDelId${i.id}">
                            <th>${i.id}</th>
                                <th id="name${i.id}">${i.name}</th>
                                <th>${i.create_time}</th>
                                <th>${i.update_time}</th>
                                <th>
                                <a class="btn btn-success edit" href="categories-edit.php?id=${i.id}&name=${i.name}"><i class="fa fa-pencil" style="color: white" aria-hidden="true"></i></a>
                                <a class="btn btn-danger delete" onclick="deleteInfoTableColom(${i.id})"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </th>
                           </tr>
                        `)
                ))
            }
        });



    $("#liveSerach").keyup(function() {
        let val= $("#liveSerach").val();

        $.ajax({
            url: 'categories-live-search-ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {value: val},
            success: function (data) {
                $("#tab").children().remove();
                data.forEach((i, k) => (
                    $("#tab").append(`
                            <tr id="trDelId${i.id}">
                            <th>${i.id}</th>
                                <th id="name${i.id}">${i.name}</th>
                                <th>${i.create_time}</th>
                                <th>${i.update_time}</th>
                                <th>
                                <a class="btn btn-success edit" href="categories-edit.php?id=${i.id}&name=${i.name}"><i class="fa fa-pencil" style="color: white" aria-hidden="true"></i></a>
                                <a class="btn btn-danger delete" onclick="deleteInfoTableColom(${i.id})"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </th>
                           </tr>
                        `)
                ))

            }
        })

    });

    function deleteInfoTableColom(deletID) {
        let del = confirm("Delete?");
        if (del === true) {
            $.ajax({
                url: 'categories-delete-ajax.php',
                type: 'POST',
                dataType: 'json',
                data: {a: deletID},
                success: function (data) {
                    if (data===true) {
                       window.location = "categories.php";
                    }
                }
            })
        }
    }
</script>
