<?php
require 'helper.php';
checkLogin();



if (isset($_POST['Customer_name']) ) {
    $selectUserSql = "SELECT * FROM customers where Customer_id = '{$_SESSION['user']["Customer_id"]}'";
    $selectUserResult = runQuery($selectUserSql);
    $selectUserRow = $selectUserResult->fetch_assoc();

    $checkExistsEmailSql = "SELECT * FROM customers WHERE Customer_username = '{$_POST['Customer_username']}' AND Customer_id != '{$_SESSION['user']["Customer_id"]}'";

    $checkExistsEmailResult = runQuery($checkExistsEmailSql);
    if ($checkExistsEmailResult->num_rows > 0) {
        header("Location: account.php?error=User Name is already in use");
        die();
    }

    $password = $selectUserRow['Customer_password'];
    if (isset($_POST['Customer_password'])) {
        if ($_POST['Customer_password'] != '') {
            $password = password_hash($_POST['Customer_password'], PASSWORD_DEFAULT);
        }
    }
    $updateSql = "UPDATE `customers` SET `Customer_name`='{$_POST['Customer_name']}',`Customer_username`='{$_POST['Customer_username']}',`Customer_password`='{$password}',`Customer_address`='{$_POST['Customer_address']}',`Customer_phone`='{$_POST['Customer_phone']}',`city_id`='{$_POST['city_id']}' WHERE Customer_id = '{$selectUserRow['Customer_id']}'";
    runQuery($updateSql);

    $_SESSION['user']['Customer_name'] = $_POST['Customer_name'];
    $_SESSION['user']['Customer_username'] = $_POST['Customer_username'];
    $_SESSION['user']['Customer_address'] = $_POST['Customer_address'];
    $_SESSION['user']['Customer_phone'] = $_POST['Customer_phone'];
    $_SESSION['user']['city_id'] = $_POST['city_id'];

    header('Location: account.php?success=Saved Successfully');


}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Foody - My Account</title>
    <?php
    require_once 'layout/assets/css.php'
    ?>
</head>

<body>
<?php
require_once 'layout/inc/header.php'
?>
<main>
    <!-- intro section -->
    <section class="section_header">
        <div class="container d-flex justify-content-between">
            <div class="navigation">
                <h2><a href="index.php">Home /</a> <br> My Account</h2>
            </div>
            <div class="thumb_img">
                <img src="assets/images/thumb.png" alt="thumb">
            </div>
        </div>
    </section>
    <!-- my account section -->
    <section class="myAccount">
        <div class="container">
            <div class="row">
                <!-- sidebar -->
                <aside class="col-md-4 col-lg-3 col-12">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        <!-- update profile tab btn -->
                        <button class="nav-link active" id="v-pills-updateProfile-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-updateProfile" type="button" role="tab"
                                aria-controls="v-pills-updateProfile" aria-selected="true">
                            <i class="fa-light fa-circle-user"></i> Update profile
                        </button>
                        <!-- my orders tab btn -->
                        <button class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-orders" type="button" role="tab" aria-controls="v-pills-orders"
                                aria-selected="false">
                            <i class="fa-light fa-bag-shopping"></i> My orders
                        </button>
                        <!-- log out btn -->
                        <a href="#!"><i class="fa-regular fa-arrow-right-from-bracket"></i> Log out</a>
                    </div>
                </aside>
                <!-- account info -->
                <div class="col-md-8 col-lg-9 col-12 ps-4 pe-4">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- update profile tab content -->
                        <?php
                        require_once 'account/profile.php';
                        require_once 'account/orders.php';
                        ?>

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