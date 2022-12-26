<?php

$driver = 'mysql';
$host = 'localhost';
$db_user = 'root';
$charset = 'utf8';
$db_name = 'tested';
$db_pass = 'mysql';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try{
    $pdo = new PDO(
        "$driver:host=$host;dbname=$db_name;charset=$charset",
        $db_user, $db_pass, $options);
}catch (PDOException $i){
    die("Connection error");
}
