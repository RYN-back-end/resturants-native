<?php
require 'helper.php';

session_start();


if (!isset($_GET['id'])) {
    echo "<script> window.location = document.referrer;</script>";
    die();
}

$selectTheProductSql = "SELECT * FROM menu_item WHERE item_id = {$_GET['id']}";
$selectTheProductResult = runQuery($selectTheProductSql);

if ($selectTheProductResult->num_rows == 0) {
    header('Location: index.php');
    die();
}
$selectTheProductResult = $selectTheProductResult->fetch_assoc();
$categoryResult = runOneQuery("SELECT * FROM menu_categories WHERE cat_id = {$selectTheProductResult['cat_id']}");
$restaurantResult = runOneQuery("SELECT * FROM restaurants WHERE restaurant_id = {$selectTheProductResult['restaurant_id']}");


$customer_id = $_SESSION['user']['Customer_id']??0;
$item_id = $_GET['id'] ?? 0;

$selectCountSql = "SELECT * FROM `cart` where `customer_id` = $customer_id And `item_id` = {$item_id}";
$selectCountResult = runQuery($selectCountSql);
$selectCountOne = $selectCountResult->fetch_assoc();

$selectAnotherProductsSql = "SELECT * FROM menu_item WHERE item_id != {$_GET['id']} AND cat_id = {$categoryResult['cat_id']} ORDER BY RAND() LIMIT 3";
$selectAnotherProductsResult = runQuery($selectAnotherProductsSql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foody - <?php echo $selectTheProductResult['item_name'] ?></title>
    <!-- ****** CSS ****** -->
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
                <h2>
                    <a href="index.php">Home /</a>
                    <a href="restaurant.php?id=<?php echo $restaurantResult['restaurant_id'] ?>"><?php echo $restaurantResult['restaurant_name'] ?></a>
                    <br> <?php echo $selectTheProductResult['item_name'] ?>
                </h2>
            </div>
            <div class="thumb_img">
                <img src="<?php echo $restaurantResult['restaurant_image'] ?>" alt="thumb">
            </div>
        </div>
    </section>
    <!-- propuct details section -->
    <section class="product-details-section">

        <div class="container">
            <?php
            if (isset($_GET['error'])) {
                ?>
                <div class="alert alert-danger" role="alert" style="text-align: right">
                    <?php echo $_GET['error']; ?>
                    <button type="button" style="float: left" class="close" data-bs-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            }
            if (isset($_GET['success'])) {
                ?>
                <div class="alert alert-success" role="alert" style="text-align: right">
                    <?php echo $_GET['success']; ?>
                    <button type="button" style="float: left" class="close" data-bs-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            }
            if (isset($_GET['warning'])) {
                ?>
                <div class="alert alert-warning" role="alert" style="text-align: right">
                    <?php echo $_GET['warning']; ?>
                    <button type="button" style="float: left" class="close" data-bs-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            }
            ?>
            <div class="row justify-content-between">
                <div class="col-lg-6 col-12">
                    <div class="image">
                        <img src="<?php echo $selectTheProductResult['item_image'] ?>" alt="product-details">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="pro_overview">
                        <h3><?php echo $selectTheProductResult['item_name'] ?></h3>
                        <div class="d-flex gap-5 align-items-center">
                            <h4><?php echo $selectTheProductResult['item_price'] ?>$</h4>
                            <p class="category">Category: <span><?php echo $categoryResult['cat_name'] ?></span></p>
                        </div>
                        <p>
                            <?php echo $selectTheProductResult['item_description'] ?>
                        </p>
                        <h6>
                            Components
                        </h6>
                        <p>
                            <?php echo $selectTheProductResult['item_ingredients'] ?>
                        </p>
                        <form action="add-to-cart.php">
                            <div class="d-flex align-items-end gap-5">
                                <div class="quantity">
                                    <input type="hidden" name="id"
                                           value="<?php echo $selectTheProductResult['item_id'] ?>">
                                    <button type="button" class="cartButton"
                                            data-id="<?php echo $selectTheProductResult['item_id'] ?>"
                                            data-type="minus">
                                        <i class="fa-sharp fa-light fa-minus"></i>
                                    </button>
                                    <input type="number" id="cartInput<?php echo $selectTheProductResult['item_id'] ?>"
                                           value="<?php echo $selectCountOne['qty'] ?? 1 ?>" name="qty" min="0" max="99"
                                           step="1"/>
                                    <button type="button" class="cartButton"
                                            data-id="<?php echo $selectTheProductResult['item_id'] ?>" data-type="plus">
                                        <i class="fa-sharp fa-light fa-plus"></i>
                                    </button>
                                </div>

                                <?php
                                if ($selectCountResult->num_rows > 0) {
                                    ?>
                                    <input type="hidden" name="cart_id"
                                           value="<?php echo $selectCountOne['id'] ?>">
                                    <?php
                                }
                                ?>
                                <div class="add_cart">
                                    <button type="submit">
                                        <?php
                                        echo $selectCountResult->num_rows > 0 ? 'Update The CART' : 'ADD TO CART';
                                        ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- related_products -->
    <section class="related_products">
        <div class="container">
            <h2>Related Products</h2>
            <div class="row">
                <?php
                if ($selectAnotherProductsResult->num_rows > 0) {
                    while ($row = $selectAnotherProductsResult->fetch_assoc()) {
                        ?>
                        <div class="col-lg-4 col-md-6 col-12 p-3">
                            <div class="product-card">
                                <!-- count -->
                                <span>
                                    <a href="add-to-cart.php?id=<?php echo $row['item_id'] ?>" style="color: white">
                                       <i class="fa-light fa-cart-plus"></i>
                                    </a>
                            </span>
                                <!-- image -->
                                <a href="product-details.php?id=<?php echo $row['item_id'] ?>" class="pro_img">
                                    <img src="<?php echo $row['item_image'] ?>" alt="">
                                </a>
                                <!-- name - price -->
                                <div class="pro_info">
                                    <a href="product-details.php?id=<?php echo $row['item_id'] ?>"><?php echo $row['item_name'] ?></a>
                                    <h4>$<?php echo $row['item_price'] ?></h4>
                                </div>
                                <!-- description - components -->
                                <div class="pro_description">
                                    <p>
                                        <?php echo $row['item_description'] ?>
                                    </p>
                                    <h6>components</h6>
                                    <p><?php echo $row['item_ingredients'] ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- product -->
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
</main>
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