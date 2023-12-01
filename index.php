<?php

require 'helper.php';
$selectAllRestaurantsSql = "SELECT * FROM restaurants ORDER BY restaurant_id DESC LIMIT 6;";
$selectAllRestaurantsResult = runQuery($selectAllRestaurantsSql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Foody - Home</title>
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
    <!-- hero section -->
    <section class="hero-section">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url(assets/images/slide1.jpg);">
                    <div class="slide-content">
                        <h2>Discover Culinary Adventures</h2>
                        <p>
                            Welcome to Foody, your gateway to a world of culinary wonders. Embark on a gastronomic
                            journey with us as we uncover top-tier restaurants, secret recipes, and delectable
                            dishes from across the globe. Are you prepared for an epic food adventure?
                        </p>
                        <a href="restaurants.html">
                            Oreder Now
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image: url(assets/images/slide2.jpg);">
                    <div class="slide-content">
                        <h2>Join the Foody Community</h2>
                        <p>
                            Foody is not just a website; it's a community of food enthusiasts. Share your foodie
                            experiences, discover hidden gems, and connect with fellow connoisseurs. Whether you're
                            a chef, a critic, or just a food lover, you're invited to be a part of our vibrant Foody
                            family.
                        </p>
                        <a href="contct-us.html">
                            Get in touch
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image: url(assets/images/slide3.jpg);">
                    <div class="slide-content">
                        <h2>Experience Food Like Never Before</h2>
                        <p>
                            At Foody, we believe in celebrating the art of cooking. Our restaurant series unveils
                            the stories behind your favorite dishes and the talented chefs who create them. From
                            street food to Michelin-starred cuisine, we've got it all. Come, savor every bite with
                            us.
                        </p>
                        <a href="about-us.html">
                            Discover More
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="heroSwiper-pagination"></div>
        </div>
    </section>
    <!-- most popular restauranrs -->
    <section class="restaurants-section">
        <div class="container">
            <h2 class="title">
                Most Popular Restaurants
            </h2>
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