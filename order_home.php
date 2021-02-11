<?php
    require_once('server.php');
    session_start();

    if(isset($_POST['userID'])) {
        echo $_POST['userID'];
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

    <script src="https://static.line-scdn.net/liff/edge/versions/2.7.1/sdk.js"></script>

    <script>
        liff.init({ liffId: "1655607383-lza4vpZb" }, () => {
            if(liff.isLoggedIn()) {
                liff.getProfile().then(profile => {
                    document.getElementById("userId").append(profile.userId)
                    const uid = profile.userId;
                    console.log(uid);
                })
            } else {
                liff.login();
            }
        }, err => console.error(err.code, error.message));
    </script>
    <div class="container">
    <div class="form">
        <p style="font-size:25px">สั่งอาหาร (รับที่ร้าน)</p><br>
        <div class="input-field">
            <label for="name">ชื่อลูกค้า</label>
            <input type="name" placeholder="ชื่อ - นามสกุล">
        </div>
        <div class="input-field">
            <label for="phone">เบอร์ติดต่อ</label>
            <input type="phone" placeholder="เบอร์โทรศัพท์">
        </div>
        <div class="input-field">
            <label for="time">เวลารับอาหาร</label>
            <input type="time" placeholder="เวลา">
        </div>
        <div class="input-field">
            <label for="menu">กรุณาเลือกเมนูที่ต้องการ</label>
            <label for="menu1">
                <input type="checkbox" name="">กระเพราหมูสับ
            </label>
            <label for="menu2">
                <input type="checkbox" name="">คะน้าหมูกรอบ
            </label>
            <label for="menu3">
                <input type="checkbox" name="">ข้าวผัดไก่
            </label>
        </div>
        <div class="action">
        <p id="userId"><b>UID: </b></p>
        <button class="btn" onclick="location.href='order_success.php'">ยืนยัน</button>
        </div>
    </div>
    </div>
</body>
</html>