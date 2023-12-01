<?php
include __DIR__ . '/../system/core.php';
require('../helper.php');
checkAdminLogin();
$selectRestaurantsSql = 'SELECT * FROM restaurants order by restaurant_id DESC';
$selectRestaurantsResult = runQuery($selectRestaurantsSql);


if (isset($_POST['type']) && isset($_POST['restaurant_id']) && $_POST['type'] == 'edit') {
    $updateSql = "UPDATE restaurants SET `restaurant_name` = '{$_POST['restaurant_name']}' ,`restaurant_address` = '{$_POST['restaurant_address']}' 
                     
                     ,`restaurant_phone` = '{$_POST['restaurant_phone']}' , `restaurant_username` = '{$_POST['restaurant_username']}' , `city_id` = '{$_POST['city_id']}' ";

    if (isset($_POST['restaurant_password'])) {
        if ($_POST['restaurant_password'] != '') {
            $password = password_hash($_POST['restaurant_password'], PASSWORD_DEFAULT);
            $updateSql .= ", `restaurant_password` = '{$password}'";
        }
    }

    if (isset($_POST['restaurant_image'])) {
    }

    $imagePath = "";
    if (isset($_FILES['restaurant_image']) && $_FILES['restaurant_image']) {
        $errors = array();
        $file_name = (time() * 2) . '.jpg';
        $file_size = $_FILES['restaurant_image']['size'];
        $file_tmp = $_FILES['restaurant_image']['tmp_name'];
        $file_type = $_FILES['restaurant_image']['type'];
        if ($file_size > 2097152) {
            header("Location: index.php?error=The image size must be less than 2MB");
        }
        if (move_uploaded_file($file_tmp, "../uploads/restaurants/" . $file_name)) {
            $imagePath = "uploads/restaurants/" . $file_name;
            $updateSql .= ", `restaurant_image` = '{$imagePath}'";
        }
    }
    $updateSql .= "WHERE `restaurant_id` = '{$_POST['restaurant_id']}'";

    runQuery($updateSql);
    header("Location: index.php");
}

if (isset($_POST['type']) && $_POST['type'] == 'new') {
    $imagePath = "";
    if (isset($_FILES['restaurant_image']) && $_FILES['restaurant_image']) {
        $errors = array();
        $file_name = (time() * 2) . '.jpg';
        $file_size = $_FILES['restaurant_image']['size'];
        $file_tmp = $_FILES['restaurant_image']['tmp_name'];
        $file_type = $_FILES['restaurant_image']['type'];
        if ($file_size > 2097152) {
            header("Location: index.php?error=The image size must be less than 2MB");
        }
        if (move_uploaded_file($file_tmp, "../uploads/restaurants/" . $file_name)) {
            $imagePath = "uploads/restaurants/" . $file_name;
            $updateSql .= ", `restaurant_image` = '{$imagePath}'";
        }
    }
    $password = password_hash($_POST['restaurant_password'], PASSWORD_DEFAULT);

    $insertSql = "INSERT INTO `restaurants`(`restaurant_name`, `restaurant_address`, `restaurant_phone`, `restaurant_username`, `restaurant_password`, `city_id`, `restaurant_image`) VALUES ('{$_POST['restaurant_name']}','{$_POST['restaurant_address']}','{$_POST['restaurant_phone']}','{$_POST['restaurant_username']}','{$password}','{$_POST['city_id']}','{$imagePath}')";
    runQuery($insertSql);
    header("Location: index.php");
}

if (isset($_GET['method']) && $_GET['method'] == 'DELETE' && isset($_GET['id'])) {
    $deleteID = $_GET['id'];
    $sql = "DELETE FROM restaurants WHERE restaurant_id = '{$deleteID}'";
    runQuery($sql);
    header('Location: index.php');
}


?>
<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">
<head>
    <meta charset="utf-8"/>
    <title>Restaurants</title>
    <?php
    include_once 'layout/assets/css.php';
    ?>
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
    <?php
    include_once 'layout/inc/counter.php';
    ?>
    <!--control -->
    <section class="tableSection">
        <div class="tableHead">
            <h6>Restaurants</h6>
            <button class="btn customBtn" data-bs-toggle="modal" data-bs-target="#createModal">Add Restaurant</button>
        </div>
        <div class="tableDiv">
            <table id="table" class="table datatable table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Image</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($selectRestaurantsResult->num_rows > 0) {
                    while ($row = $selectRestaurantsResult->fetch_assoc()) {
                        $selectCitySql = "SELECT * FROM cities where city_id = '{$row['city_id']}'";
                        $selectCityResult = runQuery($selectCitySql);
                        ?>

                        <tr>
                            <th><?php echo $row['restaurant_name'] ?></th>
                            <th><?php echo $row['restaurant_address'] ?></th>
                            <th><?php echo $row['restaurant_phone'] ?></th>
                            <th><?php echo $selectCityResult->fetch_assoc()['city_name'] ?? '' ?></th>
                            <th><img src="../<?php echo $row['restaurant_image'] ?>" style="width: 100px;"></th>
                            <th>
                                <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo $row['restaurant_id'] ?>"><i
                                            class="fa-light fa-edit"></i></button>
                                <a href="?method=DELETE&id=<?php echo $row['restaurant_id'] ?>"
                                   class="btn btn-danger confirmation"><i class="fa-light fa-trash"></i></a>
                            </th>
                        </tr>


                        <div class="modal fade" id="editModal<?php echo $row['restaurant_id'] ?>" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="type" value="edit">
                                            <input type="hidden" name="restaurant_id"
                                                   value="<?php echo $row['restaurant_id'] ?>">
                                            <div class="row">
                                                <div class="col-sm-6 col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Name </label>
                                                        <input name="restaurant_name" type="text" class="form-control"
                                                               required value="<?php echo $row['restaurant_name'] ?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Address </label>
                                                        <input name="restaurant_address" type="text"
                                                               class="form-control" required
                                                               value="<?php echo $row['restaurant_address'] ?>"
                                                               placeholder="Address">
                                                    </div>
                                                </div>
                                                <div class="col-sm- col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Phone </label>
                                                        <input name="restaurant_phone" type="number"
                                                               class="form-control" required
                                                               value="<?php echo $row['restaurant_phone'] ?>"
                                                               placeholder="Phone">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> City </label>
                                                        <select class="form-control" name="city_id" required>
                                                            <?php
                                                            if ($countAllCitiesResult->num_rows > 0) {
                                                                foreach ($cities ?? [] as $rowCity) {
                                                                    ?>
                                                                    <option value="<?php echo $rowCity['city_id'] ?? '' ?>" <?php echo $rowCity['city_id'] == $row['city_id'] ? 'selected' : '' ?> ><?php echo $rowCity['city_name'] ?? '' ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm- col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> User Name </label>
                                                        <input name="restaurant_username" type="text"
                                                               class="form-control" required
                                                               value="<?php echo $row['restaurant_username'] ?>"
                                                               placeholder="User Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm- col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Password </label>
                                                        <input name="restaurant_password" type="password"
                                                               class="form-control"
                                                               value=""
                                                               placeholder="Password">
                                                    </div>
                                                </div>
                                                <div class="col-sm- col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Image </label>
                                                        <input name="restaurant_image" type="file"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
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

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="type" value="new">
                        <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Name </label>
                                    <input name="restaurant_name" type="text" class="form-control"
                                           required value=""
                                           placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Address </label>
                                    <input name="restaurant_address" type="text"
                                           class="form-control" required
                                           value=""
                                           placeholder="Address">
                                </div>
                            </div>
                            <div class="col-sm- col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Phone </label>
                                    <input name="restaurant_phone" type="number"
                                           class="form-control" required
                                           value=""
                                           placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-6">
                                <div class="inputFeild">
                                    <label for=""> City <?php echo $countAllCitiesResult->num_rows; ?> </label>
                                    <select class="form-control" name="city_id" required>
                                        <?php
                                        if ($countAllCitiesResult->num_rows > 0) {
                                            foreach ($cities ?? [] as $rowCity) {
                                                ?>
                                                <option value="<?php echo $rowCity['city_id'] ?? '' ?>"><?php echo $rowCity['city_name'] ?? '' ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm- col-lg-6">
                                <div class="inputFeild">
                                    <label for=""> User Name </label>
                                    <input name="restaurant_username" type="text"
                                           class="form-control" required
                                           value=""
                                           placeholder="User Name">
                                </div>
                            </div>
                            <div class="col-sm- col-lg-6">
                                <div class="inputFeild">
                                    <label for=""> Password </label>
                                    <input name="restaurant_password" type="password"
                                           class="form-control"
                                           required
                                           value=""
                                           placeholder="Password">
                                </div>
                            </div>
                            <div class="col-sm- col-lg-6">
                                <div class="inputFeild">
                                    <label for=""> Image </label>
                                    <input name="restaurant_image" required type="file"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</content>

<?php
include_once 'layout/assets/js.php';
?>
</body>
</html>
