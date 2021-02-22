<?php
    require_once('server.php');
    session_start();

    $uid = $_SESSION['uid'];

    if(isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])) {

        $RestaurantName = $_REQUEST['txt_resname'];
        $RestaurantAddress = $_REQUEST['txt_resaddress'];
        $RestaurantTime = $_REQUEST['txt_restime'];

        if(empty($RestaurantName)) {
            $errorMsg = "Please enter your Restaurant Name";
        } 
        if(empty($RestaurantAddress)) {
            $errorMsg = "Please enter your Restaurant Address";
        } 
        if(empty($RestaurantTime)) {
            $errorMsg = "Please enter Restaurant Time";
        } 
        try {
            if(!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE users SET RestaurantName = :fresname, RestaurantAddress = :fresaddress, RestaurantTime = :frestime WHERE id = :id");
                $update_stmt->bindParam(':fresname', $RestaurantName);
                $update_stmt->bindParam(':fresaddress', $RestaurantAddress);
                $update_stmt->bindParam(':frestime', $RestaurantTime);
                $update_stmt->bindParam(':id', $id);

                if($update_stmt->execute()) {
                    $updateMsg = "Record update Successfully...";
                    header("refresh:2;Home.php");
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    <div class="container">
    <div class="display-3 text-center">Edit</div>

    <?php
        if(isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>

    <?php
        if(isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
            <div class="form-group text-center">
                <div class="row">
                    <label for="ResName" class="col-sm-3 control-label">Restaurant Name</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_resname" class="form-control" value="<?php echo $RestaurantName ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="ResAddress" class="col-sm-3 control-label">Restaurant Address</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_resaddress" class="form-control" value="<?php echo $RestaurantAddress ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="ResTime" class="col-sm-3 control-label">Restaurant Open-Close Time</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_restime" class="form-control" value="<?php echo $RestaurantTime ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3"></div>
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="Home.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>

    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>