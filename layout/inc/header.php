<?php
require(__DIR__ . '/../../helper.php');
if (!isset($_SESSION)) {
    session_start();
}
$customer_id = $_SESSION['user']['Customer_id'] ?? 0;

$selectAllCartSql = "SELECT
    cart.customer_id,
    SUM(cart.qty * menu_item.item_price) AS total_price
FROM
    cart
JOIN
    menu_item ON cart.item_id = menu_item.item_id
WHERE
    cart.customer_id = {$customer_id}
GROUP BY
    cart.customer_id;";

$selectAllCartResult = runOneQuery($selectAllCartSql);

?>
<header>
    <nav class="container">
        <div class="logo">
            <a href="index.php">Foody</a>
        </div>
        <ul class="nav-links">
            <li>
                <a href="index.php" class="nav-link active">Home</a>
            </li>
            <li>
                <a href="about-us.html" class="nav-link">About us</a>
            </li>
            <li>
                <a href="restaurants.php" class="nav-link">Restaurants</a>
            </li>
            <li>
                <a href="contct-us.html" class="nav-link">Contact us</a>
            </li>
        </ul>
        <div class="btns">
            <!-- if user logged in this link will point to My Account page -->

            <?php
            if (isset($_SESSION['user']['loggedin']) && $_SESSION['user']['loggedin'] == true) {
                ?>
                <div class="btn">
                    <a href="account.php">
                        <i class="fa-solid fa-user"></i>
                        <span><?php echo $_SESSION['user']['Customer_name']; ?></span>
                    </a>
                </div>
                <div class="btn">
                    <a href="logout.php">
                        <i class="fa-solid fa-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </div>
                <div class="btn">
                    <a href="shopping-cart.php">
                        <i class="fa-light fa-bag-shopping"></i>
                        <span> <?php echo $selectAllCartResult['total_price']??'0.00' ?> $</span>
                    </a>
                </div>
                <?php
            } else {
                ?>

                <div class="btn">
                    <a href="login.php">
                        <i class="fa-solid fa-user"></i>
                        <span>Login</span>
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="btn">
                <button class="toggler">
                    <i class="fa-sharp fa-light fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
</header>
