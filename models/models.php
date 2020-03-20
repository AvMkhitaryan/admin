<?php
session_start();
include "../connectDb.php";
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
                <h4>Models</h4>
                <a class="btn btn-warning " id="Categoria" href="../categories/categories.php">categories</a>
                <a class="btn btn-success" href="../models/models.php">Models</a>
                <a class="btn btn-primary" HREF="../Product/product.php">Product</a>
            </div>
            <div id="center-section" class="col-10">
                <div class="d-flex">
                    <table class="table table-dark">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Categoria_name</th>
                            <th scope="col">Create_time</th>
                            <th scope="col">Upted_time</th>
                            <th class="SercBox" scope="col"><input id="liveSerach" type="text" name="serach" placeholder="Serach For Name"></th>
                        </tr>
                        </thead>
                        <tbody id="table_id">

                        </tbody>
                    </table>
                    <div>
                        <a href="models-select.php" class="btn btn-success btn-sm">Create Mode</a>
                    </div>
                </div>
                <?php $nRows = $conn->query('select count(*) from `models`')->fetchColumn(); ?>
                <div id="pageNumber" class="d-flex justify-content-center">

                </div>
                <div id="pag" class="d-flex justify-content-center" data-id="<?=$nRows ?>">
                    <div id="left_clikc">

                    </div>
                    <div id="center_for_num">

                    </div>
                    <div id="rigthe_clikc">

                    </div>
                </div>
            </div>
            <div class="col-1">
                <a href="../Logout.php" class="btn btn-danger exit">EXIT</a>
                <div id="noneDiv" onclick="fun(1)"></div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} else {
    header("Location:login.php");
}
?>
<script>
    $("#noneDiv").click();
    let datID=$("#pag").attr("data-id");
    let forNum=Math.floor(datID /10);
    if (datID>10){
        for (let i=0; i<=forNum; i++) {
            $("#center_for_num").append(`
             <button onclick="fun(${i + 1})" class="btn btn-outline-dark">${i + 1}</button>
            `)
        }
    }
    $("#liveSerach").keyup(function() {
       let val= $("#liveSerach").val();
           $.ajax({
           url: 'models-live-search-ajax.php',
           type: 'POST',
           dataType: 'json',
           data: {value: val},
           success: function (data) {

               console.log(data);
               $("#table_id").children().remove();
               for (let i=0;i<=data.length;i++){
                   if (i<10){
                       $("#left_clikc").children().remove();
                       $("#rigthe_clikc").children().remove();
                       $("#center_for_num").children().remove();
                   }
               }
               data.forEach((i,k) => (
                   $("#table_id").append(` <tr>
                         <th scope="row">${i.id}</th>
                         <td>${i.name}</td>
                         <td>${i.cat_name}</td>
                         <td>${i.create_time}</td>
                         <td>${i.update_time}</td>
                         <td><a class="btn btn-success edit" href="models-edit.php?id=${i.id}&name=${i.name}"><i class="fa fa-pencil" style="color: white" aria-hidden="true"></i></a>
                             <a class="btn btn-danger delete" onclick="deleteInfoTableColom(${i.id})"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                     </tr>
                    `)
               ))
           }
       })
    });
    function fun(arg){
        let datID=$("#pag").attr("data-id");
        let forNum=Math.floor(datID /10);

        if (forNum>1){
            $("#pageNumber").children().remove();
            $("#pageNumber").append(`<h4>Page ${arg} of ${forNum+1}</h4>`);
        }

       let v=forNum+1;

        $.ajax({
            url: 'models-conecte.php',
            type: 'post',
            dataType: 'json',
            data:{page:arg},
            success: function (data) {
                let datID=$("#pag").attr("data-id");
                $("#left_clikc").children().remove();
                if (arg!==1){
                    $("#left_clikc").append(`<button onclick="fun(${arg}-1)" class="btn btn-outline-dark"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>`);
                }
                $("#rigthe_clikc").children().remove();
                if (arg!==v && datID>10){
                    $("#rigthe_clikc").append(`<button onclick="fun(${arg}+1)" class="btn btn-outline-dark"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>`);
                }
                $("#table_id").children().remove();
                data.forEach((i,k) => (
                    $("#table_id").append(` <tr>
                         <th scope="row">${i.id}</th>
                         <td>${i.name}</td>
                         <td>${i.cat_name}</td>
                         <td>${i.create_time}</td>
                         <td>${i.update_time}</td>
                         <td><a class="btn btn-success edit" href="models-edit.php?id=${i.id}&name=${i.name}&cat_name=${i.cat_name}"><i class="fa fa-pencil" style="color: white" aria-hidden="true"></i></a>
                             <a class="btn btn-danger delete" onclick="deleteInfoTableColom(${i.id})"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                     </tr>
                     `)
                ));
            }
        })
    }
    function deleteInfoTableColom(deletID) {
        let del = confirm("Delete?");
        if (del === true) {
            $.ajax({
                url: 'models-delete.php',
                type: 'POST',
                dataType: 'json',
                data: {a: deletID},
                success: function (data) {
                    if (data === true) {
                        window.location = "models.php";
                    }
                }
            })
        }
    }
</script>
