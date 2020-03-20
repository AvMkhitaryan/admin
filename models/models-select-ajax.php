<?php
include "../connectDb.php";
$Categoria_name=$_POST["arg2"];
$name=$_POST["arg1"];
echo "true";
$sql = "INSERT INTO `models` (name, category_id, create_time,update_time)VALUES ('$name','$Categoria_name', now(),now())";
$conn->exec($sql);
