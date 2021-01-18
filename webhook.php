<?php

    include('server.php'); 

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
    } else if ($text == "เมนูอาหาร") {
        $replyText =   {
            "type": "flex",
            "altText": "Hello Flex Message",  // แก้ตรงนี้นะครับ
            "contents": {
              "type": "bubble",
              "direction": "ltr",
              "header": {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "text",
                    "text": "Purchase",
                    "size": "lg",
                    "align": "start",
                    "weight": "bold",
                    "color": "#009813"
                  },
                  {
                    "type": "text",
                    "text": "฿ 100.00",
                    "size": "3xl",
                    "weight": "bold",
                    "color": "#000000"
                  },
                  {
                    "type": "text",
                    "text": "Rabbit Line Pay",
                    "size": "lg",
                    "weight": "bold",
                    "color": "#000000"
                  },
                  {
                    "type": "text",
                    "text": "2019.02.14 21:47 (GMT+0700)",
                    "size": "xs",
                    "color": "#B2B2B2"
                  },
                  {
                    "type": "text",
                    "text": "Payment complete.",
                    "margin": "lg",
                    "size": "lg",
                    "color": "#000000"
                  }
                ]
              },
              "body": {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "separator",
                    "color": "#C3C3C3"
                  },
                  {
                    "type": "box",
                    "layout": "baseline",
                    "margin": "lg",
                    "contents": [
                      {
                        "type": "text",
                        "text": "Merchant",
                        "align": "start",
                        "color": "#C3C3C3"
                      },
                      {
                        "type": "text",
                        "text": "BTS 01",
                        "align": "end",
                        "color": "#000000"
                      }
                    ]
                  },
                  {
                    "type": "box",
                    "layout": "baseline",
                    "margin": "lg",
                    "contents": [
                      {
                        "type": "text",
                        "text": "New balance",
                        "color": "#C3C3C3"
                      },
                      {
                        "type": "text",
                        "text": "฿ 45.57",
                        "align": "end"
                      }
                    ]
                  },
                  {
                    "type": "separator",
                    "margin": "lg",
                    "color": "#C3C3C3"
                  }
                ]
              },
              "footer": {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "View Details",
                    "size": "lg",
                    "align": "start",
                    "color": "#0084B6",
                    "action": {
                      "type": "uri",
                      "label": "View Details",
                      "uri": "https://google.co.th/"
                    }
                  }
                ]
              }
            }
          }    
    } else {
        $replyText["type"] = "text";
        $replyText["text"] = $text;
    }

    // $getUser = $conn->query("SELECT * FROM `Customer` WHERE `UserID`='$userID'");
    // $getuserNum = $getUser->num_rows;
    // $replyText["type"] = "text";
    // if ($getuserNum == "0"){
    // $replyText["text"] = "สวัสดีคับบบบ";
    // } else {
    // while($row = $getUser->fetch_assoc()){
    //     $Name = $row['Name'];
    //     $Surname = $row['Surname'];
    //     $CustomerID = $row['CustomerID'];
    // }
    // $replyText["text"] = "สวัสดีคุณ $Name $Surname (#$CustomerID)";
    // }

    $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
    $lineData['AccessToken'] = "uEbhTcwlpe54y5BHzyjzFpmp8IjkmYvEftYlagXn2HijGkFNv3ONRMVE72iqX5YJETG1T59BEhq4d9T+2x9Vs5QFyLNytZVsV0zbPEvpV51g7H3j7TmJuFTZ1clOB7PlzPTYE/bCXc3a2NNyRC47nAdB04t89/1O/w1cDnyilFU=";

    // $replyJson["replyToken"] = $replyToken;
    // $replyJson["messages"][0] = $replyText;

    $replyJson = [
        'replyToken' => $replyToken,
        'messages' => [$replyText]
    ];

    $encodeJson = json_encode($replyJson);

    $results = sendMessage($encodeJson,$lineData);
    echo $results;
    http_response_code(200);
?>