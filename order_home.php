<?php
    require_once('server.php');
    session_start();

    // if(isset($_POST['userID'])) {
    //     echo $_POST['userID'];
    // }
    if(isset($_REQUEST['btn_order'])) {
        $Name = $_REQUEST['txt_name'];
        $Phone = $_REQUEST['txt_phone'];
        // $Time = $_REQUEST['txt_time'];
        // $Food1 = $_REQUEST['txt_menu1'];
        // $Food2 = $_REQUEST['txt_menu2'];
        // $Food3 = $_REQUEST['txt_menu3'];

        if(empty($Name)){
            $errorMsg = "Please enter your name";
        } else if(empty($Phone)) {
            $errorMsg = "Please enter your phone number";
        } 
        // else if(empty($Time)) {
        //     $errorMsg = "Please insert times";
        // }
        // } else if(empty($Food1) && empty($Food2) && empty($Food3)) {
        //     $errorMsg = "Please select your menu";
        // } 
        try {
            if(!isset($errorMsg)) {
                $insert_stmt = $db->prepare("INSERT INTO customer_order(Name, Phone) VALUES (:fname, :fphone)");
                $insert_stmt->bindParam(':fname', $Name);
                $insert_stmt->bindParam(':fphone',$Phone);
                // $insert_stmt->bindParam(':ftime',$Time);
                // $insert_stmt->bindParam(':ffood', $Food1 . $Food2 . $Food3);

                if($insert_stmt->execute()) {
                    $insertMsg = "Insert Successfully...";
                    header("refresh:2;order_success.php");
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
    <link rel="stylesheet" href="order.css">
</head>
<body>

    <!-- <script src="https://static.line-scdn.net/liff/edge/versions/2.7.1/sdk.js"></script>

    <script>
        liff.init({ liffId: "1655607383-lza4vpZb" }, () => {
            if(liff.isLoggedIn()) {
                liff.getProfile().then(profile => {
                    document.getElementById("userId").append(profile.userId)
                    const uid = profile.userId;
                })
            } else {
                liff.login();
            }
        }, err => console.error(err.code, error.message));
    </script> -->

    <div class="container">
    <p id="userId"><b>UID: </b></p>
    <div class="form">
        <p style="font-size:25px">สั่งอาหาร (รับที่ร้าน)</p><br>
        <div class="input-field">
            <label for="name">ชื่อลูกค้า</label>
            <input type="name" name="txt_name" placeholder="ชื่อ - นามสกุล">
        </div>
        <div class="input-field">
            <label for="phone">เบอร์ติดต่อ</label>
            <input type="phone" name="txt_phone" placeholder="เบอร์โทรศัพท์">
        </div>
        <div class="input-field">
            <label for="time">เวลารับอาหาร</label>
            <input type="time" name="txt_time" placeholder="เวลา">
        </div>
        <div class="input-field">
            <label for="menu">กรุณาเลือกเมนูที่ต้องการ</label>
            <label for="menu1">
                <input type="checkbox" name="txt_menu1">กระเพราหมูสับ
            </label>
            <label for="menu2">
                <input type="checkbox" name="txt_menu2">คะน้าหมูกรอบ
            </label>
            <label for="menu3">
                <input type="checkbox" name="txt_menu3">ข้าวผัดไก่
            </label>
        </div>
        <div class="action">
        <input type="submit" name="btn_order" class="btn btn-success" value="ยืนยัน">
        <!-- <button class="btn" onclick="location.href='order_success.php'">ยืนยัน</button> -->
        </div>
    </div>
    </div>
    <script src="js/bundle.js"></script>
</body>
</html>