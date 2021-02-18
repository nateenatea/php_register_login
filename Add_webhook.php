<?php
    include('server.php');
    session_start();

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Webhook</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <p>Copy Link ข้างล่าง</p>
    <p>https://line-chatbot-icute-interns-php.herokuapp.com/webhook.php?u_id=<?php echo $uid; ?></p>
    <p>แล้วกลับไปที่หน้าเว็บ Messaging API ของท่าน</p>
    <?php for ($x = 20 ; $x <= 22 ; $x++) { ?>
    <img src="TokenGuide/<?php echo $x; ?>.png" width="600" height="300"><br>
    <p>&nbsp;</p>
    <?php } ?>
    <a href="index.php" class="btn btn-warning">เสร็จสิ้น</a>
</body>
</html>