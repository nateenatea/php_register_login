<?php
    require_once('server.php');
    session_start();

    if (isset($_REQUEST['btn_insert'])) {
        $Question = $_REQUEST['txt_question'];
        $Answer = $_REQUEST['txt_answer'];

        if(empty($Question)) {
            $errorMsg = "Please enter question";
        } else if(empty($Answer)) {
            $errorMsg = "Please enter answer";
        } else {
            try {
                if(!isset($errorMsg)) {
                    $uid = $_SESSION['uid'];
                    $insert_stmt = $db->prepare("INSERT INTO chatbot_$uid(Question, Answer) VALUES (:que, :ans)");
                    $insert_stmt->bindParam(':que', $Question);
                    $insert_stmt->bindParam(':ans',$Answer);
    
                    if($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:2;chatbot.php");
                    }
                }
            } catch (PDOException $e) {
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
                    <label for="Question" class="col-sm-3 control-label">Question</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_question" class="form-control" placeholder="Enter Question...">
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <div class="row">
                    <label for="Answer" class="col-sm-3 control-label">Answer</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_answer" class="form-control" placeholder="Enter Answer...">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3"></div>
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="chatbot.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
    </form>

    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>