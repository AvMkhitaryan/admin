<?php
session_start();
include_once "connectDb.php";
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
        <script src="js/jquery-3.4.1.min.js"></script>
        <title>Document</title>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1">
                <a class="btn btn-warning " id="Categoria" href="categories/categories.php">categories</a>
                <a class="btn btn-success" href="models/models.php" >Models</a>
                <a class="btn btn-primary" HREF="Product/product.php">Product</a>
            </div>
            <div id="center-section" class="col-10">
                <table id="tab">

                </table>
                <div id="input-update">

                </div>
                <div id="input-update-form">

                </div>
                <div id="input-form">

                </div>


            </div>
            <div class="col-1">
                <a href="Logout.php" class="btn btn-danger exit">EXIT</a>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
} else {
    if (!empty($_COOKIE["login"] && $_COOKIE["cook_key"])) {
        $dbLogin = $_COOKIE["login"];
        $select = $conn->query("SELECT login, cookie_key FROM `users` WHERE login='$dbLogin' ");
        $arr = $select->fetchAll(PDO::FETCH_ASSOC);
        if ($_COOKIE["login"] == $arr[0]["login"] && $_COOKIE["cook_key"] == $arr[0]["cook_key"]) {
            ?>
            <h1>Run to the Cookie</h1>
            <a href="Logout.php" class="btn btn-danger exit">EXIT</a>
            <?php
        } else {
            header("Location:login.php");
        }
    } else {
        header("Location:login.php");
    }
}
?>
<script>
    // function infoForDb(arg) {
    //     $("#tab").children().remove();
    //     if (arg === 1) {
    //         $.ajax({
    //             url: 'will_see.php',
    //             type: 'post',
    //             dataType: 'json',
    //             success: function fun(data) {
    //                 $("#input-update").children().remove();
    //                 $("#input-update").append(`<div><button class="btn btn-success"  onclick="NewCol()">new Collom </button> </div>`);
    //
    //                 data.forEach((i, k) => (
    //                     $("#tab").append(`
    //                         <tr id="trDelId${i.id}" style="border: 1px solid black">
    //                             <th id="name${i.id}" style="border: 1px solid black; padding: 2px">${i.name}</th>
    //                             <th style="border: 1px solid black; padding: 2px">${i.create_time}</th>
    //                             <th style="border: 1px solid black; padding: 2px">${i.update_time}</th>
    //                             <th style="border: 1px solid black; padding: 2px">
    //                             <button class="btn btn-success edit" onclick="editis(${i.id})" data-id="${i.id}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
    //                             <button class="btn btn-danger delete" onclick="deleteInfoTableColom(${i.id})" data-id="${i.id}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
    //                             </th>
    //                        </tr>
    //                     `)
    //                 ))
    //             }
    //         })
    //     }
    // }

    // function NewCol() {
    //     $("#form").remove();
    //     $("#input-update").append(` <form id="form">
    //                             <h6>New calome</h6>
    //                         <input type="text" id="NewColName">
    //                         <button type="button" class="btn btn-success" onclick="upForDb()" >OK</button>
    //                          <button type="button" class="btn btn-danger" onclick="closeForeUp()">X</button>
    //                       <form>
    // `)
    // }

    function closeForeUp() {
        $("#form").remove();
    }

    function upForDb() {
        let vallue = $("#NewColName").val();
        $.ajax({
            url: 'newName.php',
            type: 'post',
            dataType: 'json',
            data: {name: vallue},
            success: function (data) {
               if (data){
                   $("#Categoria").click();
               }
            }
        });
    }

    function editis(argum) {
        $("#input-form").children().remove();
        let val = $("#name" + argum).text();
        console.log(val);
        $("#input-form").append(`<form>
                                <h6>Edit</h6>
                            <input type="text" value="${val}" id="name">
                            <button type="button" onclick="goToTable(${argum})" class="btn btn-success" >OK</button>
                             <button type="button" onclick="closeInput()" class="btn btn-danger">X</button>
                          <form>`)
    }

    function goToTable(editID) {
        let editName = $("#name").val();
        $("#input-form").children().remove();
        $.ajax({
            url: 'edit.php',
            type: 'post',
            dataType: 'json',
            data: {id: editID, NewNAme: editName},
            success: function (data) {
                if (data) {
                    $("#Categoria").click();
                }
            }
        });
    }

    // function closeInput() {
    //     $("#input-form").children().remove();
    // }

    function deleteInfoTableColom(deletID) {
        let del = confirm("Delete?");
        if (del === true) {
            $.ajax({
                url: 'deleteForTable.php',
                type: 'POST',
                dataType: 'json',
                data: {a: deletID},
                success: function (data) {
                    if (data) {
                        $("#Categoria").click();
                    }
                }
            })
        }
    }

</script>

