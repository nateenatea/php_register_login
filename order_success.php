<?php

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


    function sendlinemesg() {
        define('LINE_API',"https://notify-api.line.me/api/notify");
        define('LINE_TOKEN',"dKWHuVc0nU8e786i0TP9eWa650ZADeGKlergcwFmQ8K");
    
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

    sendlinemesg();
    $res = notify_message($message);
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
    <p style="font-size:20px">ยืนยันคำสั่งซื้อเสร็จสิ้น!</p><br>
    <p style="font-size:15px">กดปิดหน้านี้ไปได้เลย</p><br>
    </div>
    </div>
</body>
</html>