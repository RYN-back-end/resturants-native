<?php
$selectOrderSql = "SELECT * FROM `orders` WHERE `restaurant_id` = '{$_SESSION['restaurant']["restaurant_id"]}'";
$selectOrderResult = runQuery($selectOrderSql);

$selectCategoriesSql = "SELECT * FROM `menu_categories` WHERE `restaurant_id` = '{$_SESSION['restaurant']["restaurant_id"]}'";
$selectCategoriesResult = runQuery($selectCategoriesSql);

$selectItemsSql = "SELECT * FROM `menu_item` WHERE `restaurant_id` = '{$_SESSION['restaurant']["restaurant_id"]}'";
$selectItemsResult = runQuery($selectItemsSql);



?>
<section class="statisticsSection">
    <div class="row g-4">
        <a href="index.php" class="statistic col-sm-6 col-md-4 col-lg-3">
            <h5 class="top">
                <i class="fa-light fa-hospital"></i>
                Orders
            </h5>
            <div class="body">
                <h1 class="odometer"
                    data-count="<?php echo $selectOrderResult->num_rows; ?>"><?php echo $selectOrderResult->num_rows; ?></h1>
            </div>
        </a>
        <a href="categories.php" class="statistic col-sm-6 col-md-4 col-lg-3">
            <h5 class="top">
                <i class="fa-light fa-dagger"></i>
                Categories
            </h5>
            <div class="body">
                <h1 class="odometer" data-count="<?php echo $selectCategoriesResult->num_rows ?? 0; ?>"><?php echo $selectCategoriesResult->num_rows?? 0; ?></h1>
            </div>
        </a>
        <a href="products.php" class="statistic col-sm-6 col-md-4 col-lg-3">
            <h5 class="top">
                <i class="fa-light fa-user-nurse"></i>
                Products
            </h5>
            <div class="body">
                <h1 class="odometer" data-count="<?php echo $selectItemsResult->num_rows ?? 0; ?>"><?php echo $selectItemsResult->num_rows ?? 0; ?></h1>
            </div>
        </a>
    </div>
</section>
