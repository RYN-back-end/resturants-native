<?php
require 'helper.php';
checkLogin();

$cartIds = $_GET['id'] ?? 0;

$deleteSql = "DELETE FROM `cart` WHERE `id`= '${cartIds}'";
runQuery($deleteSql);


echo "<script> window.location = document.referrer;</script>";
die();


