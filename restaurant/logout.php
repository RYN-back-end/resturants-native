<?php

include __DIR__ . '../system/core.php';
require('../helper.php');
checkRestaurantLogin();
$_SESSION['restaurant'] = [];
header('Location: login.php');