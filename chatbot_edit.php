<?php
    require_once('server.php');
    session_start();
    
    $uid = $_SESSION['uid'];

    if(isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM chatbot_$uid WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])) {

        $Question = $_REQUEST['txt_question'];
        $Answer = $_REQUEST['txt_answer'];
        
        if(empty($Question)) {
            $errorMsg = "Please enter Question";
        } else if(empty($Answer)) {
            $errorMsg = "Please enter Answer";
        } else {
            try {
                if(!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE chatbot_$uid SET Question = :que_up, Answer = :ans_up WHERE id = :id");
                    $update_stmt->bindParam(':que_up', $Question);
                    $update_stmt->bindParam(':ans_up', $Answer);
                    $update_stmt->bindParam(':id', $id);
    
                    if($update_stmt->execute()) {
                        $updateMsg = "Record update Successfully...";
                        header("refresh:2;chatbot.php");
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

    <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
            <div class="form-group text-center">
                <div class="row">
                    <label for="Question" class="col-sm-3 control-label">Question</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_question" class="form-control" value="<?php echo $Question ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="Answer" class="col-sm-3 control-label">Answer</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_answer" class="form-control" value="<?php echo $Answer ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3"></div>
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="chatbot.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>

    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>