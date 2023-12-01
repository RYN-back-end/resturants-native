<?php
require 'helper.php';
checkLogin();

if (!isset($_GET['id'])) {
    echo "<script> window.location = document.referrer;</script>";
    die();
}


$customer_id = $_SESSION['user']['Customer_id'];
$item_id = $_GET['id'] ?? 0;

$selectCountSql = "SELECT * FROM `cart` where `customer_id` = $customer_id And `item_id` = $item_id";
$selectCountResult = runQuery($selectCountSql);
$qty = $_GET['qty'] ?? 1;

$selectPluckItemIdsSql = "SELECT `item_id` From `cart` WHERE `customer_id` = $customer_id";

$selectPluckItemIdsResult = runQuery($selectPluckItemIdsSql);

// Check if the query was successful
if ($selectPluckItemIdsResult && $selectPluckItemIdsResult->num_rows > 0) {
    // Fetch the results and format as an array
    $itemIds = [$item_id];
    while ($row = $selectPluckItemIdsResult->fetch_assoc()) {
        $itemIds[] = $row['item_id'];
    }
    if (count($itemIds)) {
        $inSql = implode(",", $itemIds);
        $selectRestaurantIdsSql = "SELECT `restaurant_id` FROM `menu_item` WHERE `item_id` in ({$inSql})";
        $selectRestaurantIdsResult = runQuery($selectRestaurantIdsSql);
        if ($selectRestaurantIdsResult) {
            $restaurantIds = array();
            while ($row = $selectRestaurantIdsResult->fetch_assoc()) {
                if (!in_array($row['restaurant_id'], $restaurantIds)) {
                    $restaurantIds[] = $row['restaurant_id'];
                }
            }
            if (count($restaurantIds) > 1) {

                echo "<script>  var url = document.referrer;

var char = '?';
if (url.includes('?'))
{
    char = '&';
}

window.location = url+char+'warning=You must choose all products from the same store';</script>";
                die();

            }
        }
    }
    $selectPluckItemIdsResult->free();
}


if ($selectCountResult->num_rows > 0 && !isset($_GET['cart_id'])) {
    echo "<script>
 var url = document.referrer;

var char = '?';
if (url.includes('?'))
{
    char = '&';
}

window.location = url+char+'warning=The product has already been added to the cart';</script>";
    die();
}


if ($selectCountResult->num_rows > 0 && isset($_GET['cart_id'])) {
    $cartId = $selectCountResult->fetch_assoc()['id'];
    $updateSql = "UPDATE `cart` SET `qty`='{$qty}' WHERE `id`='{$_GET['cart_id']}'";
    runQuery($updateSql);
    echo "<script> 
 var url = document.referrer;

var char = '?';
if (url.includes('?'))
{
    char = '&';
}

window.location = url+char+'success=The product has been Updated successfully';</script>";
    die();

}


$storeSql = "INSERT INTO `cart`( `customer_id`, `item_id`, `qty`) VALUES ('{$customer_id}','{$item_id}',$qty)";
runQuery($storeSql);
echo "<script> var url = document.referrer;

var char = '?';
if (url.includes('?'))
{
    char = '&';
}

window.location = url+char+'success=The product has been added successfully';</script>";
die();

?>
