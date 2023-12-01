<?php
include __DIR__ . '/../system/core.php';
require('../helper.php');
checkRestaurantLogin();

$selectOrderSql = "SELECT * FROM `orders` WHERE `restaurant_id` = '{$_SESSION['restaurant']["restaurant_id"]}'";
$selectOrderResult = runQuery($selectOrderSql);

if (isset($_GET['order_id']) && isset($_GET['order_status']))
{
    $updateSql = "UPDATE `orders` SET `order_status` = '{$_GET['order_status']}' WHERE `order_id`='{$_GET['order_id']}'";
    runQuery($updateSql);
    header('Location: index.php');
}
?>
<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">
<head>
    <meta charset="utf-8"/>
    <title>Orders</title>
    <?php
    include_once 'layout/assets/css.php';
    ?>
    <style>
        <
        style >
        .table-modal {
            display: table;
            width: 100%; /* Set the width to 100% */
            border-collapse: collapse;
        }

        .table-row {
            display: inline-table;
        }

        .table-cell {
            display: table-cell;
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
<body>
<div class="back">
    <a href="logout.php" class="btn"> Logout </a>
</div>
<div class="loader-ajax" style="display: none  ; ">
    <div class="lds-grid">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div>
        </div>
    </div>
</div>
<div class="lds-hourglass"></div>

<content>
    <section class="statisticsSection">
        <div class="row g-4">
        </div>
    </section>
    <!--control -->
    <section class="tableSection">
        <div class="tableHead">
            <h6>Orders</h6>
        </div>
        <div class="tableDiv">
            <table id="table" class="table datatable table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Total Price</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                <?php
                if ($selectOrderResult->num_rows > 0) {
                while ($row = $selectOrderResult->fetch_assoc()) {

                $selectCustomer = runOneQuery("SELECT * from `customers` WHERE `customer_id` = '{$row['customer_id']}'");
                $selectCitySql = "SELECT * FROM cities where city_id = '{$selectCustomer['city_id']}'";
                $selectCityResult = runQuery($selectCitySql);

                $selectOrderDetailsResult = runQuery("SELECT * FROM `order_details` WHERE `order_id` = '{$row['order_id']}'")

                ?>

                <tr>
                    <th><?php echo $selectCustomer['Customer_name'] ?></th>
                    <th><?php echo $row['address'] ?></th>
                    <th><?php echo $selectCustomer['Customer_phone'] ?></th>
                    <th><?php echo $selectCityResult->fetch_assoc()['city_name'] ?? '' ?></th>
                    <th><?php echo $row['order_total_price'] ?></th>
                    <th>
                        <button class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#editModal<?php echo $row['order_id'] ?>"><i
                                    class="fa-light fa-info-circle"></i></button>
                    </th>
                    <th>
                        <a href="<?php
                        if ($row['order_status'] == 'accepted') {
                            echo "?order_id={$row['order_id']}&order_status=on_way";
                        } elseif ($row['order_status'] == 'on_way') {
                            echo "?order_id={$row['order_id']}&order_status=ended";
                        }else{
                            echo "#!";
                        }
                        ?>" class="btn btn-primary">
                            <?php
                            if ($row['order_status'] == 'accepted') {
                                echo "Go for delivery";
                            } elseif ($row['order_status'] == 'on_way') {
                                echo "End";
                            }else{
                                echo "Ended";
                            }
                            ?>
                        </a>
                    </th>
                </tr>
                <div class="modal fade" id="editModal<?php echo $row['order_id'] ?>" tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Details </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="modal-table">
                                            <div class="table-row col-12">
                                                <div class="table-cell col-6">Product</div>
                                                <div class="table-cell col-6">QTY</div>
                                            </div>
                                            <?php
                                            if ($selectOrderDetailsResult->num_rows > 0) {
                                                while ($rowProduct = $selectOrderDetailsResult->fetch_assoc()) {
                                                    $product = runOneQuery("SELECT * FROM `menu_item` WHERE `item_id` = '{$rowProduct['item_id']}'");
                                                    ?>
                                                    <div class="table-row col-12">
                                                        <div class="table-cell col-6"><?php echo $product['item_name'] ?></div>
                                                        <div class="table-cell col-6"><?php echo $rowProduct['qty'] ?></div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        }
                        ?>
                </tbody>

            </table>
        </div>
    </section>


</content>

<?php
include_once 'layout/assets/js.php';
?>
</body>
</html>
