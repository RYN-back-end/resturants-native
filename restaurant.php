<?php
require 'helper.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
}

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];

$fullUrl = $protocol . $domain . $uri;

$urlComponents = parse_url($fullUrl);

// Parse the query string into an associative array
parse_str($urlComponents['query'], $queryParams);

// Remove the parameter you want (e.g., 'param2')
if (isset($_GET['cat_id'])) {
    unset($queryParams['cat_id']);
}

if (isset($_GET['error'])) {
    unset($queryParams['error']);
}
if (isset($_GET['success'])) {
    unset($queryParams['success']);
}

if (isset($_GET['warning'])) {
    unset($queryParams['warning']);
}

// Rebuild the query string
$newQueryString = http_build_query($queryParams);
// Reconstruct the URL
$fullUrl = $urlComponents['scheme'] . '://' . $urlComponents['host'] . $urlComponents['path'] . '?' . $newQueryString;
$id = $_GET['id'] ?? 0;
$selectRestaurantSql = "SELECT * FROM restaurants WHERE `restaurant_id` = {$id}";
$selectRestaurantResult = runOneQuery($selectRestaurantSql);

$selectAllCategoriesSql = "SELECT * FROM menu_categories WHERE `restaurant_id` = {$id}";
$selectAllCategoriesResult = runQuery($selectAllCategoriesSql);


$cat_id = $_GET['cat_id'] ?? 'all';

$selectAllProductsSql = "SELECT * FROM menu_item WHERE `restaurant_id` = {$id}";

if ($cat_id != 'all') {
    $selectAllProductsSql .= " And `cat_id` = {$cat_id}";
}
$selectAllProductsSResult = runQuery($selectAllProductsSql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foody - <?php echo $selectRestaurantResult['restaurant_name'] ?? '' ?></title>
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
                    <a href="index.php">Home /</a> <br> <?php echo $selectRestaurantResult['restaurant_name'] ?? '' ?>
                </h2>
            </div>
            <div class="thumb_img">
                <img src=" <?php echo $selectRestaurantResult['restaurant_image'] ?? '' ?>" alt="thumb">
            </div>
        </div>
    </section>



    <section class="resturant-section">

        <!-- categories -->
        <div class="container mb-5">
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
            }   if (isset($_GET['warning'])) {
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
            <div class="swiper categoriesSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="category_card <?php echo $cat_id == 'all' ? 'active' : '' ?>">
                            <div class="icon">
                                <img src="assets/images/all.png" alt="">
                            </div>
                            <h5><a href="<?php echo $fullUrl . '&cat_id=all' ?>">Browse All</a></h5>
                        </div>
                    </div>
                    <?php
                    if ($selectAllCategoriesResult->num_rows > 0) {
                        while ($row = $selectAllCategoriesResult->fetch_assoc()) {
                            ?>
                            <div class="swiper-slide">
                                <div class="category_card <?php echo $cat_id == $row['cat_id'] ? 'active' : '' ?>">
                                    <div class="icon">
                                        <img src="<?php echo $row['cat_image'] ?? '' ?>" alt="">
                                    </div>
                                    <h5>
                                        <a href="<?php echo $fullUrl . '&cat_id=' . $row['cat_id'] ?>"><?php echo $row['cat_name'] ?? '' ?></a>
                                    </h5>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="teamSwiperPagination"></div>
            </div>
        </div>

        <!-- products -->
        <div class="container">
            <div class="row">
                <!-- product -->
                <?php
                if ($selectAllProductsSResult->num_rows > 0) {
                    while ($row = $selectAllProductsSResult->fetch_assoc()) {
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