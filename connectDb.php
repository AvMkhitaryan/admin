<?php
$host = 'mysql:host=localhost';
$username = 'root';
$password = '';


try {
    $conn = new PDO($host, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    $sql = "CREATE DATABASE IF NOT EXISTS myFirstDb DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    $conn->exec($sql);
    $sql = "use myFirstDb";
    $conn->exec($sql);

    $login = "CREATE TABLE IF NOT EXISTS `users` (
    id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    cookie_key varchar (100) NULL
   )";
$conn->exec($login);

    $login="admin";
    $pass="123456";
    $sql=$conn->prepare("INSERT INTO `users`(`login`,`password`)VALUES ('$login','$pass')");
    $user = $sql->execute();

    $categories = "CREATE TABLE IF NOT EXISTS `categories`(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    create_time DATETIME,
    update_time TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
    )";

    $conn->exec($categories);

    $sql = "INSERT INTO `categories` (name, create_time)VALUES ('Reebook', now())";
    $conn->exec($sql);


    $models = "CREATE TABLE IF NOT EXISTS `models`(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    category_id INT(11),
    create_time DATETIME,
    update_time TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
    )";

    $conn->exec($models);

    $sql = "INSERT INTO `models` (name, category_id, create_time,update_time)VALUES ('4','4.2', now(),now())";
   $conn->exec($sql);

   $alter_models = "ALTER TABLE models
    ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE";
   $conn->exec($alter_models);


    $product = "CREATE TABLE IF NOT EXISTS `product`(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    category_id INT(11),
    model_id INT(11),
    img_path VARCHAR(255),
    is_new VARCHAR(255),
    desc_info TEXT,
    price INT(11),
    create_time DATETIME,
    update_time TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)";
    $conn->exec($product);

    $product_foreign_key_one = "ALTER TABLE product
    ADD FOREIGN KEY (model_id) REFERENCES models(id) ON DELETE CASCADE ON UPDATE CASCADE";
    $conn->exec($product_foreign_key_one);

    $product_foreign_key_two = "ALTER TABLE product
    ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE";
    $conn->exec($product_foreign_key_two);

} catch (PDOException $e) {
    echo $e->getMessage();
}



