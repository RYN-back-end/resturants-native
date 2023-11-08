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
                    <div class="col-lg-4 col-12 p-2 p-2">
                        <div class="restaurant">
                            <a href="restaurant.html" class="img">
                                <img loading="lazy" src="assets/images/1.jpg" alt="store">
                            </a>
                            <div class="info">
                                <h4><a href="restaurant.html">Le Jardin Enchanté</a></h4>
                                <p><i class="fa-regular fa-location-dot"></i> 123 Main Street, New York, NY</p>
                                <p><i class="fa-regular fa-phone"></i><a href="tel:(555) 987-6543">(555) 987-6543</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 p-2">
                        <div class="restaurant">
                            <a href="restaurant.html" class="img">
                                <img loading="lazy" src="assets/images/2.jpg" alt="store">
                            </a>
                            <div class="info">
                                <h4><a href="restaurant.html">Sushi Sensation</a></h4>
                                <p><i class="fa-regular fa-location-dot"></i>789 Cherry Lane, San Francisco, CA</p>
                                <p><i class="fa-regular fa-phone"></i><a href="tel:(555) 789-1234">(555) 789-1234</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 p-2">
                        <div class="restaurant">
                            <a href="restaurant.html" class="img">
                                <img loading="lazy" src="assets/images/3.jpg" alt="store">
                            </a>
                            <div class="info">
                                <h4><a href="restaurant.html">BBQ Heaven</a></h4>
                                <p><i class="fa-regular fa-location-dot"></i> 321 Hickory Road, Austin, TX</p>
                                <p><i class="fa-regular fa-phone"></i><a href="tel:(555) 234-5678">(555) 234-5678</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 p-2">
                        <div class="restaurant">
                            <a href="restaurant.html" class="img">
                                <img loading="lazy" src="assets/images/4.jpg" alt="store">
                            </a>
                            <div class="info">
                                <h4><a href="restaurant.html">Spice Paradise</a></h4>
                                <p><i class="fa-regular fa-location-dot"></i> 567 Curry Street, Chicago, IL</p>
                                <p><i class="fa-regular fa-phone"></i><a href="tel:(555) 345-6789">(555) 345-6789</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 p-2">
                        <div class="restaurant">
                            <a href="restaurant.html" class="img">
                                <img loading="lazy" src="assets/images/2.jpg" alt="store">
                            </a>
                            <div class="info">
                                <h4><a href="restaurant.html">The Seafood Shack</a></h4>
                                <p><i class="fa-regular fa-location-dot"></i>432 Ocean View Drive, Miami, FL</p>
                                <p><i class="fa-regular fa-phone"></i><a href="tel:(555) 876-5432">(555) 876-5432</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 p-2">
                        <div class="restaurant">
                            <a href="restaurant.html" class="img">
                                <img loading="lazy" src="assets/images/6.jpg" alt="store">
                            </a>
                            <div class="info">
                                <h4><a href="restaurant.html">La Trattoria Italiana</a></h4>
                                <p><i class="fa-regular fa-location-dot"></i> 456 Oak Avenue, Los Angeles, CA</p>
                                <p><i class="fa-regular fa-phone"></i><a href="tel:(555) 987-6543">(555) 987-6543</a>
                                </p>
                            </div>
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