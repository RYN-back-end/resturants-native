<?php



$selectAllCitiesSql = "SELECT * FROM cities";
$selectAllCitiesResult = runQuery($selectAllCitiesSql);
?>

<div class="tab-pane fade show active" id="v-pills-updateProfile" role="tabpanel"
     aria-labelledby="v-pills-updateProfile-tab">
    <h4 class="greating">
        Hello, <span class="user_name">@<?php echo $_SESSION['user']['Customer_name']; ?></span> Let's update your
        profile
        information!
    </h4>
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
    <form action="account.php" method="post">
        <div class="form-group">
            <div class="input-field">
                <label for="fullName"><i class="fa-regular fa-user"></i> Full Name</label>
                <input type="text" id="fullName" required name="Customer_name"
                       placeholder="Enter your name" value="<?php echo $_SESSION['user']['Customer_name']; ?>">
            </div>
            <div class="input-field">
                <label for="userName"><i class="fa-regular fa-user"></i> User Name</label>
                <input type="text" id="userName" name="Customer_username" required
                       placeholder="Choose user name" value="<?php echo $_SESSION['user']['Customer_username']; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="input-field">
                <label for="Address"><i class="fa-sharp fa-regular fa-location-dot"></i>
                    Address</label>
                <input type="text" id="Address" name="Customer_address" required
                       placeholder="Enter your address" value="<?php echo $_SESSION['user']['Customer_address']; ?>">
            </div>
            <div class="input-field">
                <label for="City"><i class="fa-sharp fa-regular fa-location-dot"></i>
                    City</label>
                <select class="form-select" aria-label="Default select example" name="city_id" required>
                    <option selected value="">City</option>
                    <?php
                    if ($selectAllCitiesResult->num_rows > 0) {
                        while ($row = $selectAllCitiesResult->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['city_id'] ?>" <?php echo $row['city_id'] == $_SESSION['user']['city_id'] ? 'selected' : '' ?>><?php echo $row['city_name'] ?></option>
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
                <input type="text" id="Phone" name="Customer_phone" value="<?php echo $_SESSION['user']['Customer_phone']; ?>" required placeholder="Phone">
            </div>
            <div class="input-field">
                <label for="password"><i class="fa-light fa-lock"></i> Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Password">
            </div>
        </div>
        <button type="submit">update Profile</button>
    </form>
</div>
