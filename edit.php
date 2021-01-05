<?php
    require_once('server.php');

    if(isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM foodlist WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])) {
        $FoodName_up = $_REQUEST['txt_foodname'];
        $FoodPrice_up = $_REQUEST['txt_foodprice'];

        if(empty($FoodName_up)) {
            $errorMsg = "Please Enter Food Name";
        } else if(empty($FoodPrice_up)) {
            $errorMsg = "Please Enter Food Price";
        } else {
            try {
                if(!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE foodlist SET FoodName = :fname_up, FoodPrice = :fprice_up WHERE id = :id");
                    $update_stmt->bindParam(':fname_up', $FoodName_up);
                    $update_stmt->bindParam(':fprice_up', $FoodPrice_up);
                    $update_stmt->bindParam(':id', $id);

                    if($update_stmt->execute()) {
                        $updateMsg = "Record update Successfully...";
                        $FoodName = $FoodName_up;
                        $FoodPrice = $FoodPrice_up;
                        header("refresh:2;DataTable.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
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

    <form method="post" class="form-horizontal mt-5">
            <div class="form-group text-center">
                <div class="row">
                    <label for="FoodName" class="col-sm-3 control-label">Food Name</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_foodname" class="form-control" value="<?php echo $FoodName ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="FoodPrice" class="col-sm-3 control-label">Food Price</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_foodprice" class="form-control" value="<?php echo $FoodPrice ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3"></div>
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="DataTable.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>

    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>