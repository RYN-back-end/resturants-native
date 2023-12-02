<?php
include __DIR__ . '/../system/core.php';
require('../helper.php');
checkRestaurantLogin();

if (isset($_POST['type']) && $_POST['type'] == 'new') {

    $imagePath = "";
    if (isset($_FILES['cat_image']) && $_FILES['cat_image']) {
        $errors = array();
        $file_name = (time() * 2) . '.jpg';
        $file_size = $_FILES['cat_image']['size'];
        $file_tmp = $_FILES['cat_image']['tmp_name'];
        $file_type = $_FILES['cat_image']['type'];
        if ($file_size > 2097152) {
            header("Location: categories.php?error=The image size must be less than 2MB");
        }
        if (move_uploaded_file($file_tmp, "../uploads/categories/" . $file_name)) {
            $imagePath = "uploads/categories/" . $file_name;
        }
    }

    $insertSql = "INSERT INTO menu_categories (`cat_name`,`cat_image`,`restaurant_id`) VALUES ('{$_POST['cat_name']}','{$imagePath}','{$_SESSION['restaurant']["restaurant_id"]}')";
    runQuery($insertSql);
    header('Location: categories.php');
}



if (isset($_POST['type']) && isset($_POST['cat_id']) && $_POST['type'] == 'edit') {

    $updateSql = "UPDATE menu_categories SET `cat_name` = '{$_POST['cat_name']}'";


    if (isset($_FILES['cat_image']) && $_FILES['cat_image']) {
        $errors = array();
        $file_name = (time() * 2) . '.jpg';
        $file_size = $_FILES['cat_image']['size'];
        $file_tmp = $_FILES['cat_image']['tmp_name'];
        $file_type = $_FILES['cat_image']['type'];
        if ($file_size > 2097152) {
            header("Location: categories.php?error=The image size must be less than 2MB");
        }
        if (move_uploaded_file($file_tmp, "../uploads/categories/" . $file_name)) {
            $imagePath = "uploads/categories/" . $file_name;
            $updateSql.=",`cat_image`='{$imagePath}'";
        }
    }

    $updateSql.=" WHERE `cat_id` = '{$_POST['cat_id']}'";

    runQuery($updateSql);
    header('Location: categories.php');
}




if (isset($_GET['method']) && $_GET['method'] == 'DELETE' && isset($_GET['cat_id'])) {
    $deleteID = $_GET['cat_id'];
    $sql = "DELETE FROM `menu_categories` WHERE cat_id = '{$deleteID}'";
    runQuery($sql);
    header('Location: categories.php');
}

?>
<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">
<head>
    <meta charset="utf-8"/>
    <title>Categories</title>
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
    ?>

    <!--control -->
    <section class="tableSection">
        <div class="tableHead">
            <h6>Categories</h6>
            <button class="btn customBtn" data-bs-toggle="modal" data-bs-target="#createModal">Add Category</button>
        </div>
        <div class="tableDiv">
            <table id="table" class="table datatable table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($selectCategoriesResult->num_rows > 0) {
                    while ($row = $selectCategoriesResult->fetch_assoc()) {
                        ?>

                        <tr>
                            <th><?php echo $row['cat_name'] ?></th>
                            <th><img src="../<?php echo $row['cat_image'] ?>" style="width: 100px;"></th>
                            <th>
                                <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo $row['cat_id'] ?>"><i
                                            class="fa-light fa-edit"></i></button>
                            </th>
                            <th><a href="?method=DELETE&cat_id=<?php echo $row['cat_id'] ?>"
                                   class="btn btn-danger confirmation"><i class="fa-light fa-trash"></i></a></th>
                        </tr>
                        <div class="modal fade" id="editModal<?php echo $row['cat_id'] ?>" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="type" value="edit">
                                            <input type="hidden" name="cat_id" value="<?php echo $row['cat_id'] ?>">
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="inputFeild">
                                                    <label for=""> Name </label>
                                                    <input name="cat_name" type="text" class="form-control" required
                                                           value="<?php echo $row['cat_name'] ?>" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="inputFeild">
                                                    <label for=""> Image </label>
                                                    <input name="cat_image" type="file"
                                                           class="form-control">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="type" value="new">
                    <div class="col-sm-12 col-lg-12">
                        <div class="inputFeild">
                            <label for="">Name</label>
                            <input name="cat_name" type="text" class="form-control" required id="" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="inputFeild">
                            <label for=""> Image </label>
                            <input name="cat_image" type="file" required
                                   class="form-control">
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
