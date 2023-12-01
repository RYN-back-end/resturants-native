<?php
include __DIR__ . '/../system/core.php';
require('../helper.php');
checkAdminLogin();

if (isset($_POST['type']) && $_POST['type'] == 'new')
{
    $insertSql = "INSERT INTO cities (`city_name`) VALUES ('{$_POST['city_name']}')";
    runQuery($insertSql);
    header("Location: cities.php");
}

if (isset($_POST['type']) && isset($_POST['city_id']) && $_POST['type'] == 'edit')
{
    $insertSql = "UPDATE cities SET `city_name` = '{$_POST['city_name']}' WHERE `city_id` = '{$_POST['city_id']}'";
    runQuery($insertSql);
    header("Location: cities.php");
}

if (isset($_GET['method']) && $_GET['method'] == 'DELETE' && isset($_GET['city_id']))
{
    $deleteID = $_GET['city_id'];
    $sql = "DELETE FROM cities WHERE city_id = '{$deleteID}'";
    runQuery($sql);
    header('Location: cities.php');
}

?>
<!doctype html>
<html lang="ar" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">
<head>
    <meta charset="utf-8"/>
    <title>Cities</title>
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
            <h6>Cities</h6>
            <button  class="btn customBtn" data-bs-toggle="modal" data-bs-target="#createModal">Add City</button>
        </div>
        <div class="tableDiv">
            <table id="table" class="table datatable table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($countAllCitiesResult->num_rows > 0) {
                    foreach ($cities as $row) {
                        ?>

                        <tr>
                            <th><?php echo $row['city_name']?></th>
                            <th><button class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['city_id']?>"><i class="fa-light fa-edit"></i></button></th>
                            <th><a href="?method=DELETE&city_id=<?php echo $row['city_id']?>" class="btn btn-danger confirmation"><i class="fa-light fa-trash"></i></a></th>
                        </tr>
                        <div class="modal fade" id="editModal<?php echo $row['city_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="type" value="edit">
                                            <input type="hidden" name="city_id" value="<?php echo $row['city_id']?>">
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="inputFeild">
                                                    <label for=""> Name </label>
                                                    <input name="city_name" type="text" class="form-control" required value="<?php echo $row['city_name']?>" placeholder="Name">
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
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="new">
                    <div class="col-sm-12 col-lg-12">
                        <div class="inputFeild">
                            <label for="">Name</label>
                            <input name="city_name" type="text" class="form-control" required id="" placeholder="Name">
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
