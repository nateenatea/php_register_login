<?php

    require_once('server.php');
    require('payload.php');
    session_start();

    $uid = $_SESSION['uid'];

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

    if(!empty($uid)) {
        // echo "$uid";
        // Chat history
        $conn->query("INSERT INTO `log_$uid`(`UserID`, `Text`, `Timestamp`) VALUES ('$userID','$text','$timestamp')");
        $select_stmt = $db->prepare("SELECT * FROM `chatbot_$uid`");
        $select_stmt->execute();
        while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($text == $row['Question']) {
                $replyText["type"] = "text";
                $replyText["text"] = $row['Answer'];
            }
        }
    }
    else {
        // echo "Nothing Here!";
        $conn->query("INSERT INTO `log`(`UserID`, `Text`, `Timestamp`) VALUES ('$userID','$text','$timestamp')");
        $select_stmt = $db->prepare("SELECT * FROM `chatbot`");
        $select_stmt->execute();
        while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($text == $row['Question']) {
                $replyText["type"] = "text";
                $replyText["text"] = $row['Answer'];
            }
        }
    }

    if ($text == "Hello") {
        $replyText["type"] = "text";
        $replyText["text"] = "Hello from Heroku";
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
    } else if ($text == "Test") {
        $JsonFlex = $getTest;
        $replyText = json_decode($JsonFlex);
    }
    // else if ($text == "quick reply") {
    //     $JsonFlex = '{
    //        **flex message**,
    //         "quickReply": {
    //           "items": [
    //             {
    //               "type": "action",
    //               "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
    //               "action": {
    //                 "type": "message",
    //                 "label": "Message",
    //                 "text": "เมนูอาหาร"
    //               }
    //               }
    //           ]
    //         }
    //       }';
    //     $replyText = json_decode($JsonFlex);
    // }
    // else {
    //     $replyText["type"] = "text";
    //     $replyText["text"] = $text;
    // }

    // $getUser = $conn->query("SELECT * FROM `Customer` WHERE `UserID`='$userID'");
    // $getuserNum = $getUser->num_rows;
    // while($row = $getUser->fetch_assoc()){
    //     $Name = $row['Name'];
    //     $Surname = $row['Surname'];
    //     $CustomerID = $row['CustomerID'];
    // }
    // $replyText["text"] = "สวัสดีคุณ $Name $Surname (#$CustomerID)";

    if(isset($_GET["u_id"])){
        $u_id = $_GET["u_id"];

        $getAccessToken = $db->prepare("SELECT * FROM `users` WHERE `uid` = '$u_id'");
        $getAccessToken->execute();

        while($row = $getAccessToken->fetch(PDO::FETCH_ASSOC)) {
            $AccessToken = $row['accesstoken_lineoa'];
        }
    }

    $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
    // $lineData['AccessToken'] = "uEbhTcwlpe54y5BHzyjzFpmp8IjkmYvEftYlagXn2HijGkFNv3ONRMVE72iqX5YJETG1T59BEhq4d9T+2x9Vs5QFyLNytZVsV0zbPEvpV51g7H3j7TmJuFTZ1clOB7PlzPTYE/bCXc3a2NNyRC47nAdB04t89/1O/w1cDnyilFU=";
    $lineData['AccessToken'] = $AccessToken;

    $replyJson["replyToken"] = $replyToken;
    $replyJson["messages"][0] = $replyText;

    $encodeJson = json_encode($replyJson);

    echo $encodeJson;

    $results = sendMessage($encodeJson,$lineData);
    echo $results;
    http_response_code(200);
?>