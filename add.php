<?php
    require_once('server.php');
    session_start();

    if (isset($_REQUEST['btn_insert'])) {
        $FoodName = $_REQUEST['txt_foodname'];
        $FoodPrice = $_REQUEST['txt_foodprice'];
        $FoodImg = $_FILES['file_foodimg']['name'];
        $type= $_FILES['file_foodimg']['type'];
        $size = $_FILES['file_foodimg']['size'];
        $temp = $_FILES['file_foodimg']['tmp_name'];

        $uid = $_SESSION['uid'];
        $createfolder = mkdir("upload/$uid/");

        $path = "upload/$uid/" . $FoodImg; // set upload folder path

        if(empty($FoodName)) {
            $errorMsg = "Please enter Food Name";
        } else if(empty($FoodPrice)) {
            $errorMsg = "Please enter Food Price";
        } else if(empty($FoodImg)) {
            $errorMsg = "Please upload Food Image";
        } else if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif") {
            if(!file_exists($path)) { // check file not exist in your upload folder path
                if ($size < 5000000) { // check file size 5MB
                    move_uploaded_file($temp, 'upload/'.$uid.'/'.$FoodImg); // move upload file temperory directory to your upload folder
                } else {
                    $errorMsg = "Your file too large please upload 5MB size"; // error message file size larger then 5MB
                }
            } else {
                $errorMsg = "File already exists... Check upload folder"; // error message file not exists your upload folder
            }
        } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF file format...";
        } 
        try {
            if(!isset($errorMsg)) {
                $insert_stmt = $db->prepare("INSERT INTO foodlist_$uid(FoodName, FoodPrice, FoodImage) VALUES (:fname, :fprice, :fimage)");
                $insert_stmt->bindParam(':fname', $FoodName);
                $insert_stmt->bindParam(':fprice',$FoodPrice);
                $insert_stmt->bindParam(':fimage',$FoodImg);

                if($insert_stmt->execute()) {
                    $insertMsg = "Insert Successfully...";
                    header("refresh:2;DataTable.php");
                }
            }
        } catch (PDOException $e) {
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
    <div class="display-3 text-center">Add</div>

    <?php
        if(isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>

    <?php
        if(isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
            <div class="form-group text-center">
                <div class="row">
                    <label for="FoodName" class="col-sm-3 control-label">Food Name</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_foodname" class="form-control" placeholder="Enter Food Name...">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="FoodPrice" class="col-sm-3 control-label">Food Price</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_foodprice" class="form-control" placeholder="Enter Food Price...">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="FoodImg" class="col-sm-3 control-label">Food Image</label>
                    <div class="col-sm-6">
                        <input type="file" name="file_foodimg" class="form-control" placeholder="Upload Food Image...">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3"></div>
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="DataTable.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>

    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>