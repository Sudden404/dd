<?php
//mysqli
require_once 'settings.php';

$connection = new mysqli($host, $user, $pass, $data);
if ($connection->connect_error)
    die('error connection');

$query = "SELECT * FROM users";
$result = $connection->query($query);
if (!$result)
    die('error result');

$rows = $result->num_rows;
//echo '<pre>';
//print_r($rows);
//echo'</pre>';
for ($i = 0; $i < $rows; ++$i) {
    $result->data_seek($i);
    echo 'ID ' . $result->fetch_assoc()['id_user'] . ' ';
    $result->data_seek($i);
    echo 'Log ' . $result->fetch_assoc()['login'] . ' ';
    $result->data_seek($i);
    echo 'Names ' . $result->fetch_assoc()['name'] . '<br>';
}

$result->close();
$connection->close();