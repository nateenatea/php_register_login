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
        // $FoodName_up = $_REQUEST['txt_foodname'];
        // $FoodPrice_up = $_REQUEST['txt_foodprice'];

        $FoodName = $_REQUEST['txt_foodname'];
        $FoodPrice = $_REQUEST['txt_foodprice'];
        $FoodImg = $_FILES['file_foodimg']['name'];
        $type= $_FILES['file_foodimg']['type'];
        $size = $_FILES['file_foodimg']['size'];
        $temp = $_FILES['file_foodimg']['tmp_name'];

        $uid = $_SESSION['uid'];

        $path = "upload/$uid/" . $FoodImg;
        $directory = "upload/"; // set upload folder path for update time previous file remove and new file upload and new file upload for next use
        
        if(empty($FoodName)) {
            $errorMsg = "Please enter Food Name";
        } else if(empty($FoodPrice)) {
            $errorMsg = "Please enter Food Price";
        } 
        if($FoodImg) {
            if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif") {
                if(!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size < 5000000) { // check file size 5MB
                        unlink($directory.$row['FoodImage']); // uplink function remove previous file
                        move_uploaded_file($temp, 'upload/'.$FoodImg); // move upload file temperory directory to your upload folder
                    } else {
                        $errorMsg = "Your file too large please upload 5MB size"; // error message file size larger then 5MB
                    }
                } else {
                    $errorMsg = "File already exists... Check upload folder"; // error message file not exists your upload folder
                }
            } else {
                $errorMsg = "Upload JPG, JPEG, PNG & GIF file format...";
            }
        } else {
            $FoodImg = $row['FoodImage'];
        }
        try {
            if(!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE foodlist_$uid SET FoodName = :fname_up, FoodPrice = :fprice_up, FoodImage = :fimage_up WHERE id = :id");
                $update_stmt->bindParam(':fname_up', $FoodName);
                $update_stmt->bindParam(':fprice_up', $FoodPrice);
                $update_stmt->bindParam(':fimage_up', $FoodImg);
                $update_stmt->bindParam(':id', $id);

                if($update_stmt->execute()) {
                    $updateMsg = "Record update Successfully...";
                    // $FoodName = $FoodName;
                    // $FoodPrice = $FoodPrice;
                    header("refresh:2;DataTable.php");
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
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="FoodImg" class="col-sm-3 control-label">Food Image</label>
                    <div class="col-sm-6">
                        <input type="file" name="file_foodimg" class="form-control" value="<?php echo $FoodImage ?>">
                        <p>
                            <img src="upload/<?php echo $FoodImage ?>" height=100px width=100px alt="">
                        </p>
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