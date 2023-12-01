<?php
$customer_id = $_SESSION['user']['Customer_id'];

$selectOrdersSql = "SELECT * FROM `orders` WHERE `customer_id` = '{$customer_id}' order by order_id DESC ";
$selectOrdersResult = runQuery($selectOrdersSql);


?>


<!-- my orders tab content -->
<div class="tab-pane fade" id="v-pills-orders" role="tabpanel"
     aria-labelledby="v-pills-orders-tab">
    <div class="container oreders-wrapper p-0">
        <!-- order -->
        <?php
        if ($selectOrdersResult->num_rows > 0) {
            while ($row = $selectOrdersResult->fetch_assoc()) {
                $selectOrderDetailsSql = "SELECT * FROM `order_details` WHERE `order_id` = '{$row['order_id']}'";
                $selectOrderDetailsResult = runQuery($selectOrderDetailsSql);
                $selectRestaurant = runOneQuery("SELECT * FROM `restaurants` WHERE `restaurant_id` = '{$row['restaurant_id']}'");
                $selectDelivery = runOneQuery("SELECT * FROM `delivery` WHERE `delivery_id` = '{$row['delivery_id']}'");
                ?>
                <div class="order mb-4">
                    <div class="row m-0 w-100">
                        <!-- order-header -->
                        <div class="col-12 mb-3">
                            <div class="order-header">
                                <h4>Order Number:<b> <?php echo $row['order_id'] ?></b></h4>
                                <h4>Shop Name:<b> <?php echo $selectRestaurant['restaurant_name'] ?></b></h4>
                                <h4>Order Price:<b> $<?php echo $row['order_total_price'] ?></b></h4>
                                <h4>Order status:
                                    <?php
                                    if ($row['order_status'] == 'new') {
                                        echo '<span class="wait"> Waiting for store acceptance</span>';
                                    } elseif ($row['order_status'] == 'accepted') {
                                        echo '<span class="wait"> Waiting for Delivery acceptance</span>';
                                    } elseif ($row['order_status'] == 'delivery_accepted') {
                                        echo '<span class="wait">The driver was accepted</span>';
                                    } elseif ($row['order_status'] == 'on_way') {
                                        echo '<span class="wait">The driver is on the road</span>';
                                    } elseif ($row['order_status'] == 'ended') {
                                        echo '<span class="deliverd">Delivered</span>';
                                    } else {
                                        echo '<span class="rejected">Store rejected</span>';
                                    }

                                    ?>
                                </h4>
                            </div>
                        </div>
                        <?php
                        if ($selectOrderDetailsResult->num_rows > 0) {
                            while ($rowDetails = $selectOrderDetailsResult->fetch_assoc()) {
                                $selectProduct = runOneQuery("SELECT * FROM `menu_item` WHERE `item_id` = '{$rowDetails['item_id']}'");

                                ?>
                                <!-- products -->
                                <div class="col-lg-6 col-12 p-3">
                                    <div class="product-card">
                                        <!-- count -->
                                        <span><i>X<?php echo $rowDetails['qty'] ?></i></span>
                                        <!-- image -->
                                        <a href="product-details.php?id=<?php echo $rowDetails['item_id'] ?>"
                                           class="pro_img">
                                            <img src="<?php echo $selectProduct['item_image'] ?>" alt="">
                                        </a>
                                        <!-- name - price -->
                                        <div class="pro_info">
                                            <a href="product-details.html"><?php echo $selectProduct['item_name'] ?></a>
                                            <h4>$<?php echo $rowDetails['total'] ?></h4>
                                        </div>
                                        <!-- description - components -->
                                        <div class="pro_description">
                                            <p>
                                                <?php echo $selectProduct['item_description'] ?>

                                            </p>
                                            <h6>components</h6>
                                            <p><?php echo $selectProduct['item_ingredients'] ?></p>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if (!in_array($row['order_status'], ['new', 'refused'])) {
                            ?>
                            <!-- order-footer -->
                            <div class="col-12 mt-3">
                                <div class="order-footer">
                                    <h4>Delivery Agent Name:<b> <?php echo $selectDelivery['delivery_name'] ?></php></b>
                                    </h4>
                                    <h4>Delivery Agent Phone
                                        Number:<b> <?php echo $selectDelivery['delivery_phone'] ?></b></h4>
                                </div>
                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <!-- order -->
    </div>
</div>