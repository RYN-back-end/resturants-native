<?php
require('helper.php');
checkLogin();

if (isset($_POST['Customer_username'])) {
    $checkExistsSql = "SELECT * FROM customers WHERE Customer_username = '{$_POST['Customer_username']}'";

    $checkExistsResult = runQuery($checkExistsSql);
    if ($checkExistsResult->num_rows > 0) {
        header("Location: registration.php?error=User Name is already in use");
    }


    $password = password_hash($_POST['Customer_password'], PASSWORD_DEFAULT);

    $insertSql = "INSERT INTO customers (`Customer_name`,Customer_username,Customer_password,Customer_address,`Customer_phone`,`city_id`) VALUES 
                                                         ('{$_POST['Customer_name']}','{$_POST['Customer_username']}','{$password}',
                                                          '{$_POST['Customer_address']}','{$_POST['Customer_phone']}','{$_POST['city_id']}')";
    $getLastIdSql = "SELECT * FROM `customers` order by Customer_id DESC";
    runQuery($insertSql);
    $result = runQuery($getLastIdSql);
    $row = $result->fetch_assoc();
    $_SESSION['user']['Customer_id'] = $row['Customer_id'];
    $_SESSION['user']['Customer_name'] = $_POST['Customer_name'];
    $_SESSION['user']['Customer_username'] = $_POST['Customer_username'];
    $_SESSION['user']['Customer_address'] = $_POST['Customer_address'];
    $_SESSION['user']['Customer_phone'] = $_POST['Customer_phone'];
    $_SESSION['user']['city_id'] = $_POST['city_id'];
    $_SESSION['user']['loggedin'] = true;
    header('Location: index.php');
}

$selectAllCitiesSql = "SELECT * FROM cities";
$selectAllCitiesResult = runQuery($selectAllCitiesSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Foody - Register</title>
    <?php
    require_once 'layout/assets/css.php'
    ?>
</head>

<body>
<?php
require_once 'layout/inc/header.php'
?>
<main>
    <div class="login-section">
        <div class="container">
            <div class="form-wrapper">
                <div class="row">
                    <div class="col-lg-6 col-12">

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
                        }
                        ?>
                        <form action="registration.php" method="post">
                            <h2>Sign up</h2>
                            <h5>It's time to create your Foody account and savor the flavors</h5>
                            <div class="form-group">
                                <div class="input-field">
                                    <label for="fullName"><i class="fa-regular fa-user"></i> Full Name</label>
                                    <input type="text" id="fullName" name="Customer_name" required
                                           placeholder="Enter your name">
                                </div>
                                <div class="input-field">
                                    <label for="userName"><i class="fa-regular fa-user"></i> User Name</label>
                                    <input type="text" id="userName" name="Customer_username" required
                                           placeholder="Enter user name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field">
                                    <label for="Address"><i class="fa-sharp fa-regular fa-location-dot"></i>
                                        Address</label>
                                    <input type="text" id="Address" name="Customer_address" required
                                           placeholder="Enter your address">
                                </div>
                                <div class="input-field">
                                    <label for="City"><i class="fa-sharp fa-regular fa-location-dot"></i>
                                        City</label>
                                    <select class="form-select" name="city_id" required
                                            aria-label="Default select example">
                                        <option selected value="">City</option>
                                        <?php
                                        if ($selectAllCitiesResult->num_rows > 0) {
                                            while ($row = $selectAllCitiesResult->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $row['city_id'] ?>"><?php echo $row['city_name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span><i class="fa-regular fa-angle-down"></i></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="input-field">
                                    <label for="Phone"><i class="fa-regular fa-user"></i>Phone</label>
                                    <input type="text" id="Phone" name="Customer_phone" required placeholder="Phone">
                                </div>
                                <div class="input-field">
                                    <label for="password"><i class="fa-light fa-lock"></i> Password</label>
                                    <input type="password" id="password" required name="Customer_address"
                                           placeholder="Password">
                                </div>

                            </div>
                            <button type="submit">Sign up</button>
                            <p>Already have an account ? <a href="login.php">Sign In</a></p>
                        </form>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="img">
                            <img src="assets/images/signup.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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