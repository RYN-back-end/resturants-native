<?php
require('../helper.php');
checkDriverLogin();
if (isset($_POST['delivery_username']) && isset($_POST['delivery_password']))
{
    $sql = "SELECT * FROM `delivery` WHERE `delivery_username` =  '{$_POST['delivery_username']}'";
    $data = runQuery($sql);
    if ($data->num_rows >0){
        $row = $data->fetch_assoc();
       if (password_verify($_POST['delivery_password'], $row['delivery_password'])){
           $_SESSION['driver']['delivery_id'] = $row['delivery_id'];
           $_SESSION['driver']['delivery_name'] = $row['delivery_name'];
           $_SESSION['driver']['delivery_username'] = $row['delivery_username'];
           $_SESSION['driver']['city_id'] = $row['city_id'];
           $_SESSION['driver']['loggedin'] = true;
           header('Location: index.php');
       }else{
           header('Location: login.php?error=The Password Is Wrong');
       }
    }else{
        header('Location: login.php?error=The User NAme Is Invalid');
    }
    die();
}
?>

<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <meta charset="utf-8" />
    <title>Login</title>
<?php
include_once 'layout/assets/css.php';
?>
<body>
<div class="loader-ajax" style="display: none  ; ">
    <div class="lds-grid" >
        <div></div><div></div><div></div><div></div><div></div><div></div>
        <div></div><div></div><div>
        </div>
    </div>
</div>
<div class="lds-hourglass"></div>

    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mt-sm-5 mb-4 text-white-50">
                <div>
                    <a href="/" class="d-inline-block auth-logo">
                        <img src="#!" alt="" height="20">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">
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
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Welcome Back</h5>

                    </div>
                    <div class="p-2 mt-4">
                        <form action="" method="post" enctype="multipart/form" id="Form">
                            <div class="mb-3">
                                <label for="delivery_username" class="form-label">User Name</label>
                                <input type="text" class="form-control " id="delivery_username" required name="delivery_username" placeholder="use rnname">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5" required name="delivery_password" placeholder="Password" id="password-input">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" id="loginButton" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->


        </div>
    </div>
    <!-- end row -->
</div>
    <?php
    include_once 'layout/assets/js.php';
    ?>
<script>
    $('#password-addon').on('click', function() {
        var type = $('#password-input').attr('type');
        if (type == 'text')
            $('#password-input').attr('type', 'password')
        else
            $('#password-input').attr('type', 'text  ')
    })
</script>
</body>