<?php
include __DIR__ . '/../system/core.php';
require('../helper.php');
checkRestaurantLogin();


if (isset($_POST['type']) && $_POST['type'] == 'new') {
    $imagePath = "";
    if (isset($_FILES['item_image']) && $_FILES['item_image']) {
        $errors = array();
        $file_name = (time() * 2) . '.jpg';
        $file_size = $_FILES['item_image']['size'];
        $file_tmp = $_FILES['item_image']['tmp_name'];
        $file_type = $_FILES['item_image']['type'];
        if ($file_size > 2097152) {
            header("Location: products.php?error=The image size must be less than 2MB");
        }
        if (move_uploaded_file($file_tmp, "../uploads/products/" . $file_name)) {
            $imagePath = "uploads/products/" . $file_name;
        }
    }

    $insertSql = "INSERT INTO menu_item (`item_name`,`item_image`,`item_description`,`item_price`,`item_ingredients`,`cat_id`,`restaurant_id`) VALUES ('{$_POST['item_name']}','{$imagePath}','{$_POST['item_description']}','{$_POST['item_price']}','{$_POST['item_ingredients']}','{$_POST['cat_id']}','{$_SESSION['restaurant']["restaurant_id"]}')";
    runQuery($insertSql);
    header('Location: products.php');
}


if (isset($_POST['type']) && isset($_POST['item_id']) && $_POST['type'] == 'edit') {

    $updateSql = "UPDATE menu_item SET `item_name` = '{$_POST['item_name']}',`item_description`='{$_POST['item_description']}',`item_price`='{$_POST['item_price']}',`item_ingredients`='{$_POST['item_ingredients']}',`cat_id`='{$_POST['cat_id']}'";


    if (isset($_FILES['item_image']) && $_FILES['item_image']) {
        $errors = array();
        $file_name = (time() * 2) . '.jpg';
        $file_size = $_FILES['item_image']['size'];
        $file_tmp = $_FILES['item_image']['tmp_name'];
        $file_type = $_FILES['item_image']['type'];
        if ($file_size > 2097152) {
            header("Location: products.php?error=The image size must be less than 2MB");
        }
        if (move_uploaded_file($file_tmp, "../uploads/products/" . $file_name)) {
            $imagePath = "uploads/products/" . $file_name;
            $updateSql .= ",`item_image`='{$imagePath}'";
        }
    }

    $updateSql .= " WHERE `item_id` = '{$_POST['item_id']}'";

    runQuery($updateSql);
    header('Location: products.php');
}


if (isset($_GET['method']) && $_GET['method'] == 'DELETE' && isset($_GET['item_id'])) {
    $deleteID = $_GET['item_id'];
    $sql = "DELETE FROM `menu_item` WHERE item_id = '{$deleteID}'";
    runQuery($sql);
    header('Location: products.php');
}

?>
<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">
<head>
    <meta charset="utf-8"/>
    <title>Products</title>
    <?php
    include_once 'layout/assets/css.php';
    ?>
<body>
<div class="back">
    <a href="logout.php" class="btn"> logout </a>
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

    $categories = [];

    if ($selectCategoriesResult->num_rows > 0) {
        while ($row = $selectCategoriesResult->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    ?>

    <!--control -->
    <section class="tableSection">
        <div class="tableHead">
            <h6>Products</h6>
            <button class="btn customBtn" data-bs-toggle="modal" data-bs-target="#createModal">Add Prodcut</button>
        </div>
        <div class="tableDiv">
            <table id="table" class="table datatable table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>price</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($selectItemsResult->num_rows > 0) {
                    while ($row = $selectItemsResult->fetch_assoc()) {
                        $category = runOneQuery("SELECT * FROM `menu_categories` WHERE `cat_id` = '{$row['cat_id']}'")
                        ?>

                        <tr>
                            <th><?php echo $row['item_name'] ?></th>
                            <th><?php echo $category['cat_name'] ?></th>
                            <th><?php echo $row['item_price'] ?></th>
                            <th><img src="../<?php echo $row['item_image'] ?>" style="width: 100px;"></th>
                            <th>
                                <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo $row['item_id'] ?>"><i
                                            class="fa-light fa-edit"></i></button>
                            </th>
                            <th><a href="?method=DELETE&item_id=<?php echo $row['item_id'] ?>"
                                   class="btn btn-danger confirmation"><i class="fa-light fa-trash"></i></a></th>
                        </tr>
                        <div class="modal fade" id="editModal<?php echo $row['item_id'] ?>" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="type" value="edit">
                                            <input type="hidden" name="item_id" value="<?php echo $row['item_id'] ?>">
                                            <div class="row">
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Name </label>
                                                        <input name="item_name" type="text" class="form-control"
                                                               required
                                                               value="<?php echo $row['item_name'] ?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Category</label>
                                                        <select class="form-control" name="cat_id" required>
                                                            <?php
                                                            foreach ($categories ?? [] as $category) {
                                                                ?>
                                                                <option value="<?php echo $category['cat_id'] ?? '' ?>" <?php echo $category['cat_id'] == $row['cat_id'] ? 'selected' : '' ?> ><?php echo $category['cat_name'] ?? '' ?></option>
                                                                <?php

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Descriptions </label>
                                                        <input name="item_description" type="text" class="form-control"
                                                               required
                                                               value="<?php echo $row['item_description'] ?>"
                                                               placeholder="Descriptions">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Price </label>
                                                        <input name="item_price" type="number" class="form-control"
                                                               required
                                                               value="<?php echo $row['item_price'] ?>"
                                                               placeholder="Price">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Price </label>
                                                        <input name="item_ingredients" type="text" class="form-control"
                                                               required
                                                               value="<?php echo $row['item_ingredients'] ?>"
                                                               placeholder="ingredients">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-6">
                                                    <div class="inputFeild">
                                                        <label for=""> Image </label>
                                                        <input name="item_image" type="file"
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
</content>
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="type" value="new">
                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <div class="inputFeild">
                                <label for=""> Name </label>
                                <input name="item_name" type="text" class="form-control"
                                       required
                                       value=""
                                       placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="inputFeild">
                                <label for=""> Category </label>
                                <select class="form-control" name="cat_id" required>
                                    <?php
                                    foreach ($categories ?? [] as $category) {
                                        ?>
                                        <option value="<?php echo $category['cat_id'] ?? '' ?>"  ><?php echo $category['cat_name'] ?? '' ?></option>
                                        <?php

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="inputFeild">
                                <label for=""> Descriptions </label>
                                <input name="item_description" type="text" class="form-control"
                                       required
                                       value=""
                                       placeholder="Descriptions">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="inputFeild">
                                <label for=""> Price </label>
                                <input name="item_price" type="number" class="form-control"
                                       required
                                       value=""
                                       placeholder="Price">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="inputFeild">
                                <label for=""> Price </label>
                                <input name="item_ingredients" type="text" class="form-control"
                                       required
                                       value=""
                                       placeholder="ingredients">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="inputFeild">
                                <label for=""> Image </label>
                                <input name="item_image" type="file"
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

<?php
include_once 'layout/assets/js.php';
?>
</body>
</html>
