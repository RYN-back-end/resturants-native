<?php
require 'helper.php';
checkLogin();

$customer_id = $_SESSION['user']['Customer_id'];
$item_id = $_GET['id'] ?? 0;

$selectCartSql = "SELECT * FROM `cart` where `customer_id` = $customer_id";
$selectCartResult = runQuery($selectCartSql);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Foody - Check out</title>
    <?php
    require_once 'layout/assets/css.php'
    ?>
</head>

<body>
<!-- header -->
<?php
require_once 'layout/inc/header.php'
?>
<!-- main wrapper -->
<main>
    <!-- intro section -->
    <section class="section_header">
        <div class="container d-flex justify-content-between">
            <div class="navigation">
                <h2><a href="index.php">Home /</a> <br> Check out</h2>
            </div>
            <div class="thumb_img">
                <img src="assets/images/thumb.png" alt="thumb">
            </div>
        </div>
    </section>
    <section class="shopppingCart">
        <div class="container">
            <!-- empty cart -->
            <!-- <div class="row justify-content-center">
                <div class="col-6">
                    <img src="assets/images/emptycart.svg" alt="">
                    <h5 class="fillCart">You cart is empty
                        <a href="restaurants.html">Fill It <i class="fa-regular fa-angle-right"></i></a>
                    </h5>
                </div>
            </div> -->
            <!-- items list -->
            <div class="items_list">
                <!-- tabel header -->
                <div class="list_header">
                    <div class="row">
                        <div class="col-4"><span>Product</span></div>
                        <div class="col-2"><span>Price</span></div>
                        <div class="col-3"><span>Quantity</span></div>
                        <div class="col-2"><span>Sub Total</span></div>
                        <div class="col-1"></div>
                    </div>
                </div>
                <!-- tabel orders -->
                <!-- order -->
                <?php
                if ($selectCartResult->num_rows > 0) {
                    while ($row = $selectCartResult->fetch_assoc()) {
                        $selectProduct = runOneQuery("SELECT * FROM `menu_item` WHERE `item_id` = '{$row['item_id']}'");
                        ?>
                        <div class="order">
                            <div class="row">
                                <div class="col-4">
                                    <a href="product-details.php?id=<?php echo $row['item_id'] ?>" class="product_info">
                                        <img src="<?php echo $selectProduct['item_image'] ?>" alt="pro1"/>
                                        <p><?php echo $selectProduct['item_name'] ?></p>
                                    </a>
                                </div>
                                <div class="col-2">
                                    <div class="center_div">
                                    <span>
                                        <?php echo $selectProduct['item_price'];?>$
                                    </span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="center_div">
                                    <span>
                                        <?php echo $row['qty']?>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="center_div">
                                    <span>
                                         <?php echo $selectProduct['item_price'] * $row['qty'] ?>$
                                    </span>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <a class="action" href="delete-cart.php?id=<?php echo $row['id'] ?>">
                                        <i class="fa-light fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <!-- table footer -->
                <div class="list_total_procced">
                    <div class="row justify-content-between">
                        <div class="col-3">
                            <div class="subtotal">
                                <span>Order Total:</span>
                                <b><?php echo $selectAllCartResult['total_price'] ?? '0.00' ?>$</b>
                            </div>
                        </div>
                        <form class="col-6 d-flex gap-3" action="place-order.php" method="post"
                              enctype="application/x-www-form-urlencoded">
                            <div class="address_field">
                                <input type="text" id="Address" name="address" required
                                       placeholder="Enter your address">
                            </div>
                            <div class="place_order">
                                <button type="submit">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- footer -->
<?php
require_once 'layout/inc/footer.php'
?>
<!-- *********** Javascript *********** -->
<!-- libraries -->
<?php
require_once 'layout/assets/js.php'
?>
</body>

</html>