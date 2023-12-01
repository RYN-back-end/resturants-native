<?php
$sqlAllRestaurants = "SELECT COUNT(restaurant_id) AS countAllRestaurants FROM restaurants";
$countAllRestaurantsResult = runQuery($sqlAllRestaurants);
$countAllRestaurants = 0;

if ($countAllRestaurantsResult->num_rows > 0) {
    $row = $countAllRestaurantsResult->fetch_assoc();
    $countAllRestaurants = $row['countAllRestaurants'];
}

$sqlDriversAll = "SELECT COUNT(delivery_id) AS countAllDrivers FROM delivery";
$countAllDriversResult = runQuery($sqlDriversAll);
$countAllDrivers = 0;

$sqlCitiesAll = "SELECT * FROM cities";
$countAllCitiesResult = runQuery($sqlCitiesAll);
$cities = [];
while ($cityRow = $countAllCitiesResult->fetch_assoc()) {
    $cities[] = $cityRow;
}


if ($countAllDriversResult->num_rows > 0) {

    $row = $countAllDriversResult->fetch_assoc();
    $countAllDrivers = $row['countAllDrivers'];
}
?>
<section class="statisticsSection">
    <div class="row g-4">
        <a href="index.php" class="statistic col-sm-6 col-md-4 col-lg-3">
            <h5 class="top">
                <i class="fa-light fa-hospital"></i>
                Restaurants
            </h5>
            <div class="body">
                <h1 class="odometer"
                    data-count="<?php echo $countAllRestaurants; ?>"><?php echo $countAllRestaurants; ?></h1>
            </div>
        </a>
        <a href="drivers.php" class="statistic col-sm-6 col-md-4 col-lg-3">
            <h5 class="top">
                <i class="fa-light fa-user-nurse"></i>
                Drivers
            </h5>
            <div class="body">
                <h1 class="odometer" data-count="<?php echo $countAllDrivers ?? 0; ?>"><?php echo $countAllDrivers ?? 0; ?></h1>
            </div>
        </a>
        <a href="cities.php" class="statistic col-sm-6 col-md-4 col-lg-3">
            <h5 class="top">
                <i class="fa-light fa-building"></i>
                Cities
            </h5>
            <div class="body">
                <h1 class="odometer"
                    data-count="<?php echo $countAllCitiesResult->num_rows ?? 0; ?>"><?php echo $countAllCitiesResult->num_rows ?? 0; ?></h1>
            </div>
        </a>
    </div>
</section>
