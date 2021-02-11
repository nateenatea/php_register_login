<script src="https://static.line-scdn.net/liff/edge/versions/2.5.0/sdk.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>

async function getUserProfile() {
    const profile = await liff.getProfile()
    document.getElementById("userId").append(profile.userId)

    const uid = profile.userId;
    var Data = new FormData();

    Data.append('userID', uid);

    $.ajax({
        url: 'https://line-chatbot-icute-interns-php.herokuapp.com/order_home.php',
        type: 'POST',
        dataType: 'json',
        data: Data,
        cache: false,
        contentType: false,
        processData: false,
        succuss: function (res) {
            
        }
    });
    
}
async function main() {
    await liff.init({ liffId: "1655607383-lza4vpZb" })
    document.getElementById("isLoggedIn").append(liff.isLoggedIn())
    if(liff.isLoggedIn()) {
        getUserProfile()
    } else {
        liff.login()
    }
}
main()
</script>

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
        <button class="btn" onclick="location.href='order_success.php'">ยืนยัน</button>
        </div>
    </div>
    </div>
</body>
</html>