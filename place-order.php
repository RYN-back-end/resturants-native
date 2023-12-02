<?php
require 'helper.php';
checkLogin();

$customer_id = $_SESSION['user']['Customer_id'];
$selectAllCartSql = "SELECT * FROM `cart` where `customer_id` = $customer_id ";
$selectAllResult = runQuery($selectAllCartSql);

$details = [];
$totalPrice = 0;
$restaurantId = 0;
$address = $_POST['address'];
if ($selectAllResult->num_rows > 0) {
    while ($row = $selectAllResult->fetch_assoc()) {
        $selectProduct = runOneQuery("SELECT * FROM `menu_item` WHERE `item_id` = '{$row['item_id']}'");
        $restaurantId = $selectProduct['restaurant_id'];
        $smallArray['item_id'] = $row['item_id'];
        $smallArray['price'] = $selectProduct['item_price'];
        $smallArray['qty'] = $row['qty'];
        $smallArray['total'] = $row['qty'] * $smallArray['price'];
        $details[] = $smallArray;
        $totalPrice += $smallArray['total'];
    }
}

$date = date('Y-m-d');
$insertSql = "INSERT INTO `orders`(`order_date`, `address`, `order_total_price`, `customer_id`, `restaurant_id`,`city_id`) VALUES ('{$date}','{$address}','{$totalPrice}','{$customer_id}','{$restaurantId}','{$_SESSION['user']['city_id']}')";
$queryResult = runQuery($insertSql);
if ($queryResult === true)
{
    $lastOrderSql = "SELECT * From `orders` order by order_id DESC";
    $lastInsertedId = runOneQuery($lastOrderSql)['order_id'];
    foreach ($details as $detail)
    {
        $insertDetailSql = "INSERT Into `order_details` (`order_id`,`item_id`,`qty`,`price`,`total`) VALUES ('{$lastInsertedId}','{$detail['item_id']}','{$detail['qty']}','{$detail['price']}','{$detail['total']}')";
        runQuery($insertDetailSql);
    }
}

runQuery("DELETE FROM `cart` where `customer_id` = $customer_id ");

header("LOCATION: index.php");