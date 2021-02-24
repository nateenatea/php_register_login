<?php
    require_once('server.php');

    $select_stmt = $db->prepare("SELECT * FROM `FoodList_$uid`");
    $select_stmt->execute();
    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      $FlexArray .= '
      {
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://line-chatbot-icute-interns-php.herokuapp.com/upload/'.$uid.'/'.$row["FoodImage"].'",
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
                "text": "ติดต่อเรา",
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
                  "uri": "https://www.facebook.com/LOVENINTENDO/"
                }
              },
              {
                "type": "button",
                "action": {
                  "type": "message",
                  "label": "เบอร์โทร",
                  "text": "999999999"
                }
              },
              {
                "type": "button",
                "action": {
                  "type": "uri",
                  "label": "แผนที่ร้าน",
                  "uri": "https://www.google.com/maps/place/หมูสองชั้น/@18.7874033,98.9325755,13z/data=!4m8!1m2!2m1!1z4Lir4Lih4Li54Liq4Lit4LiH4LiK4Lix4LmJ4LiZ!3m4!1s0x30da31baf8146447:0x379f1f18a6673df0!8m2!3d18.7769425!4d98.9810842"
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
                  "uri": "https://line-chatbot-icute-interns-php.herokuapp.com/order_res.php?u_id='.$uid.'"
                }
              },
              {
                "type": "button",
                "action": {
                  "type": "uri",
                  "label": "จัดส่งที่บ้าน",
                  "uri": "https://line-chatbot-icute-interns-php.herokuapp.com/order_home.php?u_id='.$uid.'"
                }
              }
            ]
          }
        }
      }';

    $select_stmt = $db->prepare("SELECT * FROM users WHERE `uid` = '$uid'");
    $select_stmt->execute();
    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      $ResName = $row['RestaurantName'];
      $ResAddress = $row['RestaurantAddress'];
      $ResTime = $row['RestaurantTime'];
      $ResImg = $row['RestaurantImage'];
    }

    $getMain = '{
      "type": "flex",
      "altText": "Flex Message",
      "contents": {
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://line-chatbot-icute-interns-php.herokuapp.com/upload/'.$ResImg.'",
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
              "text": "'.$ResName.'",
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
                  "type": "box",
                  "layout": "baseline",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "text",
                      "text": "ที่ตั้งร้าน",
                      "size": "sm",
                      "color": "#AAAAAA",
                      "flex": 1,
                      "contents": []
                    },
                    {
                      "type": "text",
                      "text": "'.$ResAddress.'",
                      "size": "sm",
                      "color": "#666666",
                      "flex": 5,
                      "wrap": true,
                      "contents": []
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "baseline",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "text",
                      "text": "เวลา",
                      "size": "sm",
                      "color": "#AAAAAA",
                      "flex": 1,
                      "contents": []
                    },
                    {
                      "type": "text",
                      "text": "'.$ResTime.'",
                      "size": "sm",
                      "color": "#666666",
                      "flex": 5,
                      "wrap": true,
                      "contents": []
                    }
                  ]
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
                "label": "เมนูอาหาร",
                "text": "เมนูอาหาร"
              },
              "height": "sm",
              "style": "link"
            },
            {
              "type": "spacer",
              "size": "sm"
            }
          ]
        }
      }
    }';  
?>