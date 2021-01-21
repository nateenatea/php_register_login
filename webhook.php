<?php

    include('server.php');
    include('payload.php');

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

    // Chat history
    // $conn->query("INSERT INTO `LOG`(`UserID`, `Text`, `Timestamp`) VALUES ('$userID','$text','$timestamp')");

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
    } else if ($text == "quick reply") {
        $JsonFlex = '{
            "type": "flex",
        "altText": "Flex Message",
        "contents": {
          "type": "bubble",
          "direction": "ltr",
          "header": {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "text",
                "text": "เกี่ยวกับเรา",
                "align": "center",
                "contents": []
              }
            ]
          },
          "hero": {
            "type": "image",
            "url": "https://amarinacademy.com/app/uploads/2017/06/petr-sevcovic-594807-unsplash.jpg",
            "size": "full",
            "aspectRatio": "1.51:1",
            "aspectMode": "fit"
          },
          "body": {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "text",
                "text": "เปิดทำการเวลา 10.00 - 18.00 น.",
                "align": "center",
                "contents": []
              }
            ]
          },
          "footer": {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "button",
                "action": {
                  "type": "uri",
                  "label": "Facebook",
                  "uri": "https://linecorp.com"
                }
              },
              {
                "type": "button",
                "action": {
                  "type": "uri",
                  "label": "เบอร์โทร",
                  "uri": "https://linecorp.com"
                }
              },
              {
                "type": "button",
                "action": {
                  "type": "uri",
                  "label": "แผนที่ร้าน",
                  "uri": "https://linecorp.com"
                }
              }
            ]
          }
        },
            "quickReply": {
              "items": [
                {
                  "type": "action",
                  "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
                  "action": {
                    "type": "message",
                    "label": "Message",
                    "text": "เมนูอาหาร"
                  }
                  }
              ]
            }
          }';
        $replyText = json_decode($JsonFlex);
    }
    // else if ($text == "Test") {
    //     $JsonFlex = $getTest;
    //     $replyText = json_decode($JsonFlex);      
    // } else {
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

    $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
    $lineData['AccessToken'] = "uEbhTcwlpe54y5BHzyjzFpmp8IjkmYvEftYlagXn2HijGkFNv3ONRMVE72iqX5YJETG1T59BEhq4d9T+2x9Vs5QFyLNytZVsV0zbPEvpV51g7H3j7TmJuFTZ1clOB7PlzPTYE/bCXc3a2NNyRC47nAdB04t89/1O/w1cDnyilFU=";

    $replyJson["replyToken"] = $replyToken;
    $replyJson["messages"][0] = $replyText;

    $encodeJson = json_encode($replyJson);

    $results = sendMessage($encodeJson,$lineData);
    echo $results;
    http_response_code(200);
?>