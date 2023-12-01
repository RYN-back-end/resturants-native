<?php

include __DIR__ . '../system/core.php';
require('../helper.php');
checkDriverLogin();
$_SESSION['driver'] = [];
header('Location: login.php');