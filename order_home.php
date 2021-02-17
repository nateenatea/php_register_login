<?php
    require_once('server.php');
    
    if(isset($_GET['u_id'])) {
        $uid = $_GET['u_id'];

        //Get Line Notify Token
        $getAccessToken = $db->prepare("SELECT * FROM `users` WHERE `uid` = '$uid'");
        $getAccessToken->execute();

        while($row = $getAccessToken->fetch(PDO::FETCH_ASSOC)) {
            $AccessToken = $row['accesstoken_notify'];
        }
    }

    if(isset($_REQUEST['btn_order'])) {
        $Name = $_REQUEST['txt_name'];
        $Phone = $_REQUEST['txt_phone'];
        $Address = $_REQUEST['txt_address'];
        $Foodsum = '';

        $select_stmt = $db->prepare("SELECT * FROM foodlist_$uid");
        $select_stmt->execute();

        while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            if(isset($_REQUEST['txt_menu'.$row["id"]])) {
                $Foodsum .= $_REQUEST['txt_menu'.$row["id"]] . ' ';
                $FoodPrice = $FoodPrice + $row["FoodPrice"];
            }
        }

        if(empty($Name)){
            $errorMsg = "Please enter your name";
        } else if(empty($Phone)) {
            $errorMsg = "Please enter your phone number";
        } else if(empty($Address)) {
            $errorMsg = "Please insert your address";
        } else if(empty($Foodsum)) {
            $errorMsg = "Please select your menu";
        }
        try {
            if(!isset($errorMsg) && isset($_GET['u_id'])) {
                $insert_stmt = $db->prepare("INSERT INTO `customer_order_$uid`(Name, Phone, Address, Food, Price, Status) VALUES (:fname, :fphone, :faddress, :ffood, :fprice, :fstatus)");
                $insert_stmt->bindParam(':fname', $Name);
                $insert_stmt->bindParam(':fphone', $Phone);
                $insert_stmt->bindParam(':faddress', $Address);
                $insert_stmt->bindParam(':ffood', $Foodsum);
                $insert_stmt->bindParam(':fprice', $FoodPrice);
                $status = 'รอการอนุมัติ';
                $insert_stmt->bindParam(':fstatus', $status);

                if($insert_stmt->execute()) {
                    $insertMsg = "Insert Successfully...";

                    $select_stmt = $db->prepare("SELECT * FROM customer_order_$uid");
                    $select_stmt->execute();
                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $Name = $row['Name'];
                        $Phone = $row['Phone'];
                        $Address = $row['Address'];
                        $Food = $row['Food'];
                        $Price = $row['Price'];
                        $Status = $row['Status'];
                    }

                    $header = "Order จาก UID : " . $uid;
                    $message = $header.
                            "\n". "**รับที่ร้าน**" .
                            "\n". "ชื่อ: " . $Name .
                            "\n". "เบอร์โทร: " . $Phone .
                            "\n". "ที่อยู่ในการจัดส่ง: " . $Address .
                            "\n". "อาหารที่สั่ง: " . $Food . 
                            "\n". "ราคารวมทั้งหมด: " . $Price . " บาท" .
                            "\n". "สถานะ: " . $Status;

                    function notify_message($message) {
                        global $AccessToken;

                        $queryData = array('message' => $message);
                        $queryData = http_build_query($queryData,'','&');
                        $headerOptions = array(
                            'http' => array(
                                'method' => 'POST',
                                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                                            ."Authorization: Bearer ".$AccessToken."\r\n"
                                            ."Content-Length: ".strlen($queryData)."\r\n",
                                'content' => $queryData
                            )
                        );

                        $context = stream_context_create($headerOptions);
                        $result = file_get_contents("https://notify-api.line.me/api/notify", FALSE, $context);
                        $res = json_decode($result);
                        return $res;
                    }

                    $res = notify_message($message);

                    header("refresh:0;order_success.php");
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
    <div class="container">
    <p><b>UID: <?php echo $uid ?></b></p>
    <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
        <p style="font-size:25px">สั่งอาหาร (ส่งที่บ้าน)</p><br>
        <div class="input-field">
            <label for="name">ชื่อลูกค้า</label>
            <input type="name" name="txt_name" placeholder="ชื่อ - นามสกุล">
        </div>
        <div class="input-field">
            <label for="phone">เบอร์ติดต่อ</label>
            <input type="phone" name="txt_phone" placeholder="เบอร์โทรศัพท์">
        </div>
        <div class="input-field">
            <label for="address">ที่อยู่ในการจัดส่งอาหาร</label>
            <input type="address" name="txt_address" placeholder="ที่อยู่">
        </div>
        <div class="input-field">
            <label for="menu">กรุณาเลือกเมนูที่ต้องการ</label>
            <?php
                $select_stmt = $db->prepare("SELECT * FROM foodlist_$uid");
                $select_stmt->execute();

                while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <label for="menu<?php echo $row["id"]; ?>">
                    <input type="checkbox" name="txt_menu<?php echo $row["id"]; ?>" value="<?php echo $row["FoodName"]; ?>"><?php echo $row["FoodName"]; ?>
            </label>
            <?php } ?>
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