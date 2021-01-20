<?php
    require_once('server.php');
    session_start();

    // $select_stmt = $db->prepare("SELECT * FROM `FoodList` WHERE `ID`='1'");
    $select_stmt = $db->prepare("SELECT * FROM `FoodList`");
    $select_stmt->execute();

    // while($row = $select_stmt->fetchALL(PDO::FETCH_ASSOC)) {
    //   $id = $row[1]["id"];
    //   $FoodName = $row[1]["FoodName"];
    //   $FoodPrice = $row[1]["FoodPrice"];
    //   $FoodImage = $row[1]["FoodImage"];    
    // }

    $FlexArray = [];
    while($row = $select_stmt->fetchALL(PDO::FETCH_ASSOC)) {
      $FlexArray[] = '{
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
                  "text": "'.$row["FoodPrice"].'",
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
    

    // $fetchdata = $select_stmt->fetchALL(PDO::FETCH_OBJ);
    // if ($select_stmt->rowCount() > 0) {
    //   foreach($fetchdata as $data) {
    //     $data = 
    //   }
    // }
    
    // $MenuArray = [];
    // while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $MenuArray[] = [
    //     ]
    // }

    // $FoodName = "กระเพราหมูสับ";
    // $FoodImage = "b1882dcea15df32ac2d0593cc3f0681e.jpg";
    // $FoodPrice = "40 บาท";

    $getTest = '{
      "type": "flex",
      "altText": "Flex Message",
      "contents": {
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
      }
    }';

    // $getTest = '{
    //   "type": "flex",
    //   "altText": "Flex Message",
    //   "contents": {
    //     "type": "bubble",
    //     "direction": "ltr",
    //     "header": {
    //       "type": "box",
    //       "layout": "vertical",
    //       "contents": [
    //         {
    //           "type": "text",
    //           "text": "'.$FoodName.'",
    //           "align": "center",
    //           "contents": []
    //         }
    //       ]
    //     },
    //     "hero": {
    //       "type": "image",
    //       "url": "https://line-chatbot-icute-interns-php.herokuapp.com/upload/'.$FoodImage.'",
    //       "size": "full",
    //       "aspectRatio": "1.51:1",
    //       "aspectMode": "fit"
    //     },
    //     "body": {
    //       "type": "box",
    //       "layout": "vertical",
    //       "contents": [
    //         {
    //           "type": "text",
    //           "text": "'.$FoodPrice.'",
    //           "align": "center",
    //           "contents": []
    //         }
    //       ]
    //     },
    //     "footer": {
    //       "type": "box",
    //       "layout": "vertical",
    //       "contents": [
    //         {
    //           "type": "button",
    //           "action": {
    //             "type": "uri",
    //             "label": "ทดสอบ",
    //             "uri": "https://linecorp.com"
    //           }
    //         }
    //       ]
    //     }
    //   }
    // }';

    $getMenu = '{
      "type": "flex",
      "altText": "Flex Message",
      "contents": {
        "type": "carousel",
        "contents": [
          {
            "type": "bubble",
            "direction": "ltr",
            "hero": {
              "type": "image",
              "url": "https://img.wongnai.com/p/1920x0/2019/09/13/efa96879445f46b6aa780ae1a8ed64a7.jpg",
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
                  "text": "กระเพราหมูสับ",
                  "weight": "bold",
                  "size": "xl",
                  "contents": []
                },
                {
                  "type": "box",
                  "layout": "baseline",
                  "margin": "md",
                  "contents": [
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
                    },
                    {
                      "type": "text",
                      "text": "4.0",
                      "size": "sm",
                      "color": "#999999",
                      "flex": 0,
                      "margin": "md",
                      "contents": []
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "ธรรมดา 40 บาท",
                          "weight": "bold",
                          "margin": "sm",
                          "contents": []
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "พิเศษ 45 บาท",
                          "weight": "bold",
                          "flex": 0,
                          "margin": "sm",
                          "contents": []
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "ไข่ดาว เพิ่มอีก 5 บาท",
                          "weight": "bold",
                          "margin": "sm",
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
              "contents": [
                {
                  "type": "spacer",
                  "size": "xs"
                },
                {
                  "type": "button",
                  "action": {
                    "type": "message",
                    "label": "สั่งอาหาร",
                    "text": "สั่งอาหาร"
                  },
                  "color": "#52E5F4FF",
                  "style": "primary",
                  "gravity": "top"
                }
              ]
            }
          },
          {
            "type": "bubble",
            "direction": "ltr",
            "hero": {
              "type": "image",
              "url": "https://food.mthai.com/app/uploads/2019/05/Stir-Fried-Crispy-Pork-with-Red-Curry-17.jpg",
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
                  "text": "ผัดพริกแกงหมู",
                  "weight": "bold",
                  "size": "xl",
                  "contents": []
                },
                {
                  "type": "box",
                  "layout": "baseline",
                  "margin": "md",
                  "contents": [
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
                    },
                    {
                      "type": "text",
                      "text": "3.0",
                      "size": "sm",
                      "color": "#999999",
                      "flex": 0,
                      "margin": "md",
                      "contents": []
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "ธรรมดา 40 บาท",
                          "weight": "bold",
                          "margin": "sm",
                          "contents": []
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "พิเศษ 45 บาท",
                          "weight": "bold",
                          "flex": 0,
                          "margin": "sm",
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
              "contents": [
                {
                  "type": "spacer",
                  "size": "xs"
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
          },
          {
            "type": "bubble",
            "direction": "ltr",
            "hero": {
              "type": "image",
              "url": "https://food.mthai.com/app/uploads/2017/12/Stir-Fried-Kale-with-Crispy-Pork.jpg",
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
                  "text": "กระเพราหมูสับ",
                  "weight": "bold",
                  "size": "xl",
                  "contents": []
                },
                {
                  "type": "box",
                  "layout": "baseline",
                  "margin": "md",
                  "contents": [
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "icon",
                      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
                    },
                    {
                      "type": "text",
                      "text": "5.0",
                      "size": "sm",
                      "color": "#999999",
                      "flex": 0,
                      "margin": "md",
                      "contents": []
                    }
                  ]
                },
                {
                  "type": "box",
                  "layout": "vertical",
                  "spacing": "sm",
                  "contents": [
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "ธรรมดา 45 บาท",
                          "weight": "bold",
                          "margin": "sm",
                          "contents": []
                        }
                      ]
                    },
                    {
                      "type": "box",
                      "layout": "baseline",
                      "contents": [
                        {
                          "type": "text",
                          "text": "พิเศษ 50 บาท",
                          "weight": "bold",
                          "flex": 0,
                          "margin": "sm",
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
              "contents": [
                {
                  "type": "spacer",
                  "size": "xs"
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
          },
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
              "spacing": "sm",
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