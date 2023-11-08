<?php
require 'helper.php';
checkLogin();
if (isset($_POST['Customer_username']) && isset($_POST['Customer_password'])) {
    $sql = "SELECT * FROM `customers` WHERE `Customer_username` =  '{$_POST['Customer_username']}'";
    $data = runQuery($sql);
    if ($data->num_rows > 0) {
        $row = $data->fetch_assoc();
        if (password_verify($_POST['Customer_password'], $row['Customer_password'])) {
            $_SESSION['user']['Customer_id'] = $row['Customer_id'];
            $_SESSION['user']['Customer_name'] = $row['Customer_name'];
            $_SESSION['user']['Customer_username'] = $row['Customer_username'];
            $_SESSION['user']['Customer_address'] = $row['Customer_address'];
            $_SESSION['user']['Customer_phone'] = $row['Customer_phone'];
            $_SESSION['user']['city_id'] = $row['city_id'];
            $_SESSION['user']['loggedin'] = true;
            header('Location: index.php');
        } else {
            header('Location: login.php?error=The password is incorrect');
        }
    } else {
        header('Location: login.php?error=The user name not found not found');
    }
    die();

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Foody - Login</title>
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
                        <form action="login.php" method="post" enctype="application/x-www-form-urlencoded">
                            <h2>Sign in</h2>
                            <h5>Hey, you ...! Enter your registered data to complete the login process</h5>
                            <div class="input-field">
                                <label for="userName"><i class="fa-regular fa-user"></i> User Name</label>
                                <input type="text" id="userName" name="Customer_username" required
                                       placeholder="Enter your user_name">
                            </div>
                            <div class="input-field">
                                <label for="password"><i class="fa-light fa-lock"></i> Password</label>
                                <input type="password" id="password" required name="Customer_password"
                                       placeholder="Password">
                            </div>
                            <button type="submit">Login</button>
                            <p>Don't have an account? <a href="registration.php">Create an account</a></p>
                        </form>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="img">
                            <img src="assets/images/login.svg" alt="">
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