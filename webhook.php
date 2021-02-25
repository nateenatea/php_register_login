<?php

    require_once('server.php');

    $uid = $_GET['u_id'];
    
    require('payload.php');

    $LINEData = file_get_contents('php://input');
    $jsonData = json_decode($LINEData,true);

    $replyToken = $jsonData["events"][0]["replyToken"];
    $userID = $jsonData["events"][0]["source"]["userId"];
    $text = $jsonData["events"][0]["message"]["text"];
    $timestamp = $jsonData["events"][0]["timestamp"];

    function sendMessage($replyJson, $sendInfo){
            $ch = curl_init($sendInfo["URL"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $sendInfo["AccessToken"])
                );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
            $result = curl_exec($ch);
            curl_close($ch);
    return $result;
    }

    if(isset($_GET['u_id'])) {
        // Chat history
        $conn->query("INSERT INTO `log_$uid`(`UserID`, `Text`, `Timestamp`) VALUES ('$userID','$text','$timestamp')");

        //Chatbot Q&A
        $select_stmt = $db->prepare("SELECT * FROM `chatbot_$uid`");
        $select_stmt->execute();
        while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($text === $row['Question']) {
                $replyText["type"] = "text";
                $replyText["text"] = $row['Answer'];
            } else if ($text == "เมนูหลัก") {
                $JsonFlex = $getMain;
                $replyText = json_decode($JsonFlex);      
            } else if ($text == "เมนูอาหาร") {
                $JsonFlex = $getMenu;
                $replyText = json_decode($JsonFlex);      
            } else if ($text == "เกี่ยวกับเรา") {
                $JsonFlex = $getMe;
                $replyText = json_decode($JsonFlex);      
            } else if ($text == "สั่งอาหาร") {
                $JsonFlex = $getFood;
                $replyText = json_decode($JsonFlex);      
            } else {
                $JsonFlex = '{
                    "type": "text",
                    "text": "สวัสดีครับ/ค่ะ ร้าน '.$ResName.' ยินดีให้บริการครับ/ค่ะ ลูกค้าสามารถจิ้มที่ เมนูหลัก ได้เลยครับ/ค่ะ",
                    "quickReply": {
                      "items": [
                        {
                          "type": "action",
                          "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
                          "action": {
                            "type": "message",
                            "label": "เมนูหลัก",
                            "text": "เมนูหลัก"
                          }
                        }
                      ]
                    }
                  }';
                $replyText = json_decode($JsonFlex);  
            }
        }

        //Get Access Token
        $getAccessToken = $db->prepare("SELECT * FROM `users` WHERE `uid` = '$uid'");
        $getAccessToken->execute();

        while($row = $getAccessToken->fetch(PDO::FETCH_ASSOC)) {
            $AccessToken = $row['accesstoken_lineoa'];
        }

        //Get Restaurant Name
        $getName = $db->prepare("SELECT * FROM `users` WHERE `uid` = '$uid'");
        $getName->execute();

        while($row = $getName->fetch(PDO::FETCH_ASSOC)) {
            $ResName = $row['RestaurantName'];
        }
    }

    $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
    $lineData['AccessToken'] = $AccessToken;

    $replyJson["replyToken"] = $replyToken;
    $replyJson["messages"][0] = $replyText;

    $encodeJson = json_encode($replyJson);

    echo $encodeJson;

    $results = sendMessage($encodeJson,$lineData);
    echo $results;
    http_response_code(200);
?>