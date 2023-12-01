<?php
include __DIR__ . '/../system/core.php';
require('../helper.php');
checkAdminLogin();
$selectDeliverySql = 'SELECT * FROM delivery order by delivery_id DESC';
$selectDeliveryResult = runQuery($selectDeliverySql);


if (isset($_POST['type']) && isset($_POST['delivery_id']) && $_POST['type'] == 'edit') {
    $updateSql = "UPDATE delivery SET `delivery_name` = '{$_POST['delivery_name']}' ,`delivery_address` = '{$_POST['delivery_address']}' 
                     
                     ,`delivery_phone` = '{$_POST['delivery_phone']}' , `delivery_username` = '{$_POST['delivery_username']}' , `city_id` = '{$_POST['city_id']}' ";

    if (isset($_POST['delivery_password'])) {
        if ($_POST['delivery_password'] != '') {
            $password = password_hash($_POST['delivery_password'], PASSWORD_DEFAULT);
            $updateSql .= ", `delivery_password` = '{$password}'";
        }
    }

    $updateSql .= "WHERE `delivery_id` = '{$_POST['delivery_id']}'";

    runQuery($updateSql);
    header("Location: drivers.php");
}

if (isset($_POST['type']) && $_POST['type'] == 'new') {

    $password = password_hash($_POST['delivery_password'], PASSWORD_DEFAULT);

    $insertSql = "INSERT INTO `delivery`(`delivery_name`, `delivery_address`, `delivery_phone`, `delivery_username`, `delivery_password`, `city_id`) VALUES ('{$_POST['delivery_name']}','{$_POST['delivery_address']}','{$_POST['delivery_phone']}','{$_POST['delivery_username']}','{$password}','{$_POST['city_id']}')";
    runQuery($insertSql);
    header("Location: drivers.php");
}

if (isset($_GET['method']) && $_GET['method'] == 'DELETE' && isset($_GET['id'])) {
    $deleteID = $_GET['id'];
    $sql = "DELETE FROM delivery WHERE delivery_id = '{$deleteID}'";
    runQuery($sql);
    header('Location: drivers.php');
}


?>
<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">
<head>
    <meta charset="utf-8"/>
    <title>Drivers</title>
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
            <h6>Drivers</h6>
            <button class="btn customBtn" data-bs-toggle="modal" data-bs-target="#createModal">Add Driver</button>
        </div>
        <div class="tableDiv">
            <table id="table" class="table datatable table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($selectDeliveryResult->num_rows > 0) {
                    while ($row = $selectDeliveryResult->fetch_assoc()) {
                        $selectCitySql = "SELECT * FROM cities where city_id = '{$row['city_id']}'";
                        $selectCityResult = runQuery($selectCitySql);
                        ?>

                        <tr>
                            <th><?php echo $row['delivery_name'] ?></th>
                            <th><?php echo $row['delivery_address'] ?></th>
                            <th><?php echo $row['delivery_phone'] ?></th>
                            <th><?php echo $selectCityResult->fetch_assoc()['city_name'] ?? '' ?></th>
                            <th>
                                <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo $row['delivery_id'] ?>"><i
                                            class="fa-light fa-edit"></i></button>
                                <a href="?method=DELETE&id=<?php echo $row['delivery_id'] ?>"
                                   class="btn btn-danger confirmation"><i class="fa-light fa-trash"></i></a>
                            </th>
                        </tr>


                        <div class="modal fade" id="editModal<?php echo $row['delivery_id'] ?>" tabindex="-1"
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
                                            <input type="hidden" name="delivery_id"
                                                   value="<?php echo $row['delivery_id'] ?>">
                                            <div class="row">
                                                <div class="col-sm-6 col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Name </label>
                                                        <input name="delivery_name" type="text" class="form-control"
                                                               required value="<?php echo $row['delivery_name'] ?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Address </label>
                                                        <input name="delivery_address" type="text"
                                                               class="form-control" required
                                                               value="<?php echo $row['delivery_address'] ?>"
                                                               placeholder="Address">
                                                    </div>
                                                </div>
                                                <div class="col-sm- col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Phone </label>
                                                        <input name="delivery_phone" type="number"
                                                               class="form-control" required
                                                               value="<?php echo $row['delivery_phone'] ?>"
                                                               placeholder="Phone">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-lg-4">
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

                                                <div class="col-sm-4 col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> User Name </label>
                                                        <input name="delivery_username" type="text"
                                                               class="form-control" required
                                                               value="<?php echo $row['delivery_username'] ?>"
                                                               placeholder="User Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-lg-4">
                                                    <div class="inputFeild">
                                                        <label for=""> Password </label>
                                                        <input name="delivery_password" type="password"
                                                               class="form-control"
                                                               value=""
                                                               placeholder="Password">
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="type" value="new">
                        <div class="row">
                            <div class="col-sm-6 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Name </label>
                                    <input name="delivery_name" type="text" class="form-control"
                                           required value=""
                                           placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Address </label>
                                    <input name="delivery_address" type="text"
                                           class="form-control" required
                                           value=""
                                           placeholder="Address">
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Phone </label>
                                    <input name="delivery_phone" type="number"
                                           class="form-control" required
                                           value=""
                                           placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
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

                            <div class="col-sm-4 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> User Name </label>
                                    <input name="delivery_username" type="text"
                                           class="form-control" required
                                           value=""
                                           placeholder="User Name">
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="inputFeild">
                                    <label for=""> Password </label>
                                    <input name="delivery_password" type="password"
                                           class="form-control"
                                           required
                                           value=""
                                           placeholder="Password">
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
