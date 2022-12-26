<?php
//PDO

$connection = new PDO("mysql:host=localhost;dbname=mytest;charset=utf8","root","mysql");

$query = "INSERT users (name, age, login, password) VALUE ('Славик', '32', 'живёт', 'Дома')";
$count = $connection->exec($query);

echo $count;
$count = null;//не обязательно, класс закроет себя при окончании скрипта