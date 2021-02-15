<?php
    require_once('server.php');
    session_start();

    // if(isset($_POST['userID'])) {
    //     echo $_POST['userID'];
    // }

    if(isset($_GET['u_id'])) {
        $uid = $_GET['u_id'];
    }

    function sendlinemesg() {
        //Get Line Notify Token
        $getAccessToken = $db->prepare("SELECT * FROM `users` WHERE `uid` = '$uid'");
        $getAccessToken->execute();

        while($row = $getAccessToken->fetch(PDO::FETCH_ASSOC)) {
            $AccessToken = $row['accesstoken_notify'];
        }
        define('LINE_API',"https://notify-api.line.me/api/notify");
        define('LINE_TOKEN',$AccessToken);
    
        function notify_message($message) {
            $queryData = array('message' => $message);
            $queryData = http_build_query($queryData,'','&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                                ."Authorization: Bearer ".LINE_TOKEN."\r\n"
                                ."Content-Length: ".strlen($queryData)."\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents(LINE_API, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }
    }

    if(isset($_REQUEST['btn_order'])) {
        $Name = $_REQUEST['txt_name'];
        $Phone = $_REQUEST['txt_phone'];
        $Time = $_REQUEST['txt_time'];
        $Foodsum = '';
        if(isset($_REQUEST['txt_menu1'])) {
            $Foodsum .= $_REQUEST['txt_menu1'] . ' ';
        }
        if(isset($_REQUEST['txt_menu2'])) {
            $Foodsum .= $_REQUEST['txt_menu2'] . ' ';
        }
        if(isset($_REQUEST['txt_menu3'])) {
            $Foodsum .= $_REQUEST['txt_menu3'] . ' ';
        } 

        if(empty($Name)){
            $errorMsg = "Please enter your name";
        } else if(empty($Phone)) {
            $errorMsg = "Please enter your phone number";
        } else if(empty($Time)) {
            $errorMsg = "Please insert times";
        } else if(empty($Foodsum)) {
            $errorMsg = "Please select your menu";
        } 
        try {
            if(!isset($errorMsg) && isset($_GET['u_id'])) {
                $insert_stmt = $db->prepare("INSERT INTO `customer_order_$uid`(Name, Phone, Time, Food, Status) VALUES (:fname, :fphone, :ftime, :ffood, :fstatus)");
                $insert_stmt->bindParam(':fname', $Name);
                $insert_stmt->bindParam(':fphone', $Phone);
                $insert_stmt->bindParam(':ftime', $Time);
                $insert_stmt->bindParam(':ffood', $Foodsum);
                $status = 'รอการอนุมัติ';
                $insert_stmt->bindParam(':fstatus', $status);

                if($insert_stmt->execute()) {
                    $insertMsg = "Insert Successfully...";

                    $select_stmt = $db->prepare("SELECT * FROM customer_order_$uid");
                    $select_stmt->execute();
                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $Name = $row['Name'];
                        $Phone = $row['Phone'];
                        $Time = $row['Time'];
                        $Food = $row['Food'];
                        $Status = $row['Status'];
                    }

                    $header = "Order จาก UID : " . $uid;
                    $message = $header.
                            "\n". "ชื่อ: " . $Name .
                            "\n". "เบอร์โทร: " . $Phone .
                            "\n". "เวลารับอาหาร: " . $Time .
                            "\n". "อาหารที่สั่ง: " . $Food . 
                            "\n". "สถานะ: " . $Status;

                    sendlinemesg();
                    $res = notify_message($message);

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
    <!-- <p id="userId"><b>UID: </b></p> -->
    <p><b>UID: <?php echo $uid ?></b></p>
    <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
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
                <input type="checkbox" name="txt_menu1" value="กระเพราหมูสับ">กระเพราหมูสับ
            </label>
            <label for="menu2">
                <input type="checkbox" name="txt_menu2" value="คะน้าหมูกรอบ">คะน้าหมูกรอบ
            </label>
            <label for="menu3">
                <input type="checkbox" name="txt_menu3" value="ข้าวมันไก่">ข้าวผัดไก่
            </label>
        </div>
        <div class="action">
        <input type="submit" name="btn_order" class="btn btn-success" value="ยืนยัน">
        <!-- <button class="btn" onclick="location.href='order_success.php'">ยืนยัน</button> -->
        </div>
    </form>
    </div>
    <script src="js/bundle.js"></script>
</body>
</html>