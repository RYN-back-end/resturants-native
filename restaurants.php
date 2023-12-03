<?php

require 'helper.php';
$selectAllRestaurantsSql = "SELECT * FROM restaurants ORDER BY restaurant_id DESC";
$selectAllRestaurantsResult = runQuery($selectAllRestaurantsSql);


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Foody - Restaurants</title>
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
                    <h2><a href="index.php">Home /</a> <br> Restaurants</h2>
                </div>
                <div class="thumb_img">
                    <img src="assets/images/thumb.png" alt="thumb">
                </div>
            </div>
        </section>
        <!-- Restaurants section -->
        <section class="restaurants-section">
            <div class="container">
                <div class="row">
                    <?php
                    if ($selectAllRestaurantsResult->num_rows > 0) {
                        while ($row = $selectAllRestaurantsResult->fetch_assoc()) {
                            ?>
                            <div class="col-lg-4 col-12 p-2">
                                <div class="restaurant">
                                    <a href="restaurant.php?id=<?php echo $row['restaurant_id']?>" class="img">
                                        <img loading="lazy" src="<?php echo $row['restaurant_image']?>" alt="store">
                                    </a>
                                    <div class="info">
                                        <h4><a href="restaurant.php?id=<?php echo $row['restaurant_id']?>"><?php echo $row['restaurant_name']?></a></h4>
                                        <p><i class="fa-regular fa-location-dot"></i><?php echo $row['restaurant_address']?></p>
                                        <p><i class="fa-regular fa-phone"></i><a href="tel:<?php echo $row['restaurant_phone']?>"><?php echo $row['restaurant_phone']?>"</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <!-- footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="logo">
                        <a href="#home">Foody <span></span></a>
                    </div>
                    <p>
                        Foody is not just a website; it's a community of food enthusiasts. Share your foodie
                        experiences, discover hidden gems, and connect with fellow connoisseurs.
                    </p>
                    <div class="social">
                        <a href="#home"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#home"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#home"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#home"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <h3>Restaurants</h3>
                    <ul>
                        <li><a href="#">Italian Pasta</a></li>
                        <li><a href="#">Beef Burger</a></li>
                        <li><a href="#">Chinese Sushi</a></li>
                        <li><a href="#">Italian Pizza</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Payment & Tax</a></li>
                        <li><a href="#">Order Delivery</a></li>
                        <li><a href="#">Terms of Services</a></li>
                        <li><a href="#">My account</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <h3>Stay connected</h3>
                    <form action="">
                        <input type="text" placeholder="Email Address">
                        <button type="submit"><i class="fa-solid fa-chevron-right"></i></button>
                    </form>
                    <h4><i class="fa-solid fa-headset"></i><a href="tel++17602781253">+17602781253</a></h4>
                    <h4><i class="fa-solid fa-envelope"></i><a href="mailto:Foody@gmail.com">Foody@gmail.com</a></h4>
                </div>
                <div class="copy d-flex align-items-center justify-content-center">
                    <p>
                        Copyright © 2023 All rights reserved | This template is made with
                        <i class="fa-light fa-heart"></i> by OurTeam
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- *********** Javascript *********** -->
    <!-- libraries -->
    <!-- [jQuery v3.6.4 - Bootstrap v5.3.0 - Swiper 8.4.5 - Aos ] -->
    <script src="assets/js/main.js"></script>
    <!-- custom scripts -->
    <script src="assets/js/app.js"></script>
</body>

</html>