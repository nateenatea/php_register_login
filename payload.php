<?php
    require_once('server.php');
    session_start();

    $select_stmt = $db->prepare("SELECT * FROM FoodList");
    $select_stmt->execute();

    while($row = $select_stmt->fetch_assoc()){
      $id = $row["id"];
      $FoodName = $row["FoodName"];
      $FoodPrice = $row["FoodPrice"];
      $FoodImage = $row["FoodImage"];    
    }

    $data = '{
      "type": "bubble",
      "direction": "ltr",
      "header": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "'.$FoodName.'",
            "align": "center",
            "contents": []
          }
        ]
      },
      "hero": {
        "type": "image",
        "url": "https://line-chatbot-icute-interns-php.herokuapp.com/upload/'.$FoodImage.'",
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
            "text": "'.$FoodPrice.'",
            "align": "center",
            "contents": []
          }
        ]
      },
      "footer": {
        "type": "box",
        "layout": "horizontal",
        "contents": [
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "Button",
              "uri": "https://linecorp.com"
            }
          }
        ]
      }
    },';

    // $fetchdata = $select_stmt->fetchALL(PDO::FETCH_OBJ);
    // if ($select_stmt->rowCount() > 0) {
    //   foreach($fetchdata as $data) {
    //     $data = 
    //   }
    // }

    // while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $row["id"];
    //     $row["FoodName"];
    //     $row["FoodPrice"];
    //     $row["FoodImage"];
    // }
    // $test = "เกี่ยวกับเรา";
    // "text": "'.$test.'",
    
    // $MenuArray = [];
    // while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $MenuArray[] = [
    //     ]
    // }

    $getMenu = '{
        "type": "carousel",
        "contents": [
            '.$data.'
        ]
      }';

    $getMe = '{
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
        }
      }';

    $getFood = '{
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
                "text": "ช่องทางการรับอาหาร",
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
                  "label": "รับเองที่ร้าน",
                  "uri": "https://linecorp.com"
                }
              },
              {
                "type": "button",
                "action": {
                  "type": "uri",
                  "label": "จัดส่งที่บ้าน",
                  "uri": "https://linecorp.com"
                }
              }
            ]
          }
        }
      }';

    $getMain = '{
        "type": "template",
        "altText": "this is a buttons template",
        "template": {
          "type": "buttons",
          "thumbnailImageUrl": "https://www.scb.co.th/content/dam/scb/personal-banking/stories-tips/thai-food/thai-food10.jpg",
          "title": "ร้าน ...",
          "text": "เปิดทุกวัน 10.00 - 18.00 น.",
          "actions": [
            {
              "type": "message",
              "label": "เมนูอาหาร",
              "text": "เมนูอาหาร"
            }
          ]
        }
      }';   
?>