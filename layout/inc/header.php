<?php
require(__DIR__ . '/../../helper.php');
if (!isset($_SESSION)) {
    session_start();
}
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
                <a href="restaurants.html" class="nav-link">Restaurants</a>
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
                    <a href="shopping-cart.html">
                        <i class="fa-light fa-bag-shopping"></i>
                        <span> $00.00</span>
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
