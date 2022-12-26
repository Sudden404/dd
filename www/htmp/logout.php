<?php
include "path.php";
session_start();
unset($_SESSION['id']);
unset($_SESSION['login']);
header('location: ' . BASE_URL);