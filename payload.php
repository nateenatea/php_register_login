<?php
    require_once('server.php');
    session_start();

    $getTest = '{
      "type":"text",
      "text":"Hi bubble 1"
    },
    {
      "type":"text",
      "text":"Hi bubble 2"
    },
    {
      "type":"text",
      "text":"Hi bubble 3"
    }';

    $select_stmt = $db->prepare("SELECT * FROM `FoodList`");
    $select_stmt->execute();

    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      $FlexArray .= '
      {
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://line-chatbot-icute-interns-php.herokuapp.com/upload/'.$row["FoodImage"].'",
          "size": "full",
          "aspectRatio": "20:13",
          "aspectMode": "cover",
          "action": {
            "type": "uri",
            "label": "Line",
            "uri": "https://linecorp.com/"
          }
        },
        "body": {
          "type": "box",
          "layout": "vertical",
          "contents": [
            {
              "type": "text",
              "text": "'.$row["FoodName"].'",
              "weight": "bold",
              "size": "xl",
              "contents": []
            },
            {
              "type": "box",
              "layout": "vertical",
              "spacing": "sm",
              "margin": "lg",
              "contents": [
                {
                  "type": "text",
                  "text": "ราคา '.$row["FoodPrice"].' บาท",
                  "weight": "bold",
                  "margin": "sm",
                  "contents": []
                }
              ]
            }
          ]
        },
        "footer": {
          "type": "box",
          "layout": "vertical",
          "flex": 0,
          "spacing": "sm",
          "contents": [
            {
              "type": "button",
              "action": {
                "type": "message",
                "label": "สั่งอาหาร",
                "text": "สั่งอาหาร"
              },
              "color": "#1DD9FBFF",
              "style": "primary"
            },
            {
              "type": "spacer",
              "size": "sm"
            }
          ]
        }
      },';
    }

    $getMenu = '{
      "type": "flex",
      "altText": "Flex Message",
      "contents": {
        "type": "carousel",
        "contents": [
          '.$FlexArray.'
        {
          "type": "bubble",
          "direction": "ltr",
          "hero": {
            "type": "image",
            "url": "https://f.ptcdn.info/093/063/000/por9fs1msd6H30qV3s8m-o.jpg",
            "size": "full",
            "aspectRatio": "20:13",
            "aspectMode": "cover",
            "action": {
              "type": "uri",
              "label": "Action",
              "uri": "https://linecorp.com"
            }
          },
          "body": {
            "type": "box",
            "layout": "vertical",
            "spacing": "md",
            "action": {
              "type": "uri",
              "label": "Action",
              "uri": "https://linecorp.com"
            },
            "contents": [
              {
                "type": "text",
                "text": "เมนูอาหารอื่นๆ",
                "weight": "bold",
                "size": "xl",
                "contents": []
              }
            ]
          },
          "footer": {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "spacer",
                "size": "xs"
              },
              {
                "type": "button",
                "action": {
                  "type": "message",
                  "label": "ดูเมนู",
                  "text": "ดูเมนู"
                },
                "color": "#52E5F4FF",
                "style": "primary"
              },
              {
                "type": "button",
                "action": {
                  "type": "message",
                  "label": "สั่งอาหาร",
                  "text": "สั่งอาหาร"
                },
                "color": "#52E5F4FF",
                "style": "primary"
              }
            ]
          }
        }
        ]
      }
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