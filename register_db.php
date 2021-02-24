<?php
    session_start();
    include('server.php');

    $errors = array();

    if(isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $ResName = mysqli_real_escape_string($conn, $_POST['Res_Name']);
        $ResAddress = mysqli_real_escape_string($conn, $_POST['Res_Address']);
        $ResTime = mysqli_real_escape_string($conn, $_POST['Res_Time']);
        $ResImg = $_FILES['Res_Img']['name'];
        $type= $_FILES['Res_Img']['type'];
        $size = $_FILES['Res_Img']['size'];
        $temp = $_FILES['Res_Img']['tmp_name'];
        $path = "upload/" . $ResImg;
        $accesstokenlineoa = mysqli_real_escape_string($conn, $_POST['accesstokenlineoa']);
        $accesstokennotify = mysqli_real_escape_string($conn, $_POST['accesstokennotify']);

        if(empty($username)) {
            array_push($errors, "Username is required");
        }
        if(empty($email)) {
            array_push($errors, "Email is required");
        }
        if(empty($password_1)) {
            array_push($errors, "Password is required");
        }
        if($password_1 != $password_2) {
            array_push($errors, "Passwords do not match");
        }
        if(empty($ResName)) {
            array_push($errors, "Restaurant Name is required");
        }
        if(empty($ResAddress)) {
            array_push($errors, "Restaurant Address is required");
        }
        if(empty($ResTime)) {
            array_push($errors, "Restaurant Open-Close Time is required");
        }
        if(empty($ResImg)) {
            array_push($errors, "Please upload Restaurant Image");
        } 
        else if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif") {
            if(!file_exists($path)) { // check file not exist in your upload folder path
                if ($size < 5000000) { // check file size 5MB
                    move_uploaded_file($temp, 'upload/'.$ResImg); // move upload file temperory directory to your upload folder
                } else {
                    array_push($errors, "Your file too large please upload 5MB size"); // error message file size larger then 5MB
                }
            } else {
                array_push($errors, "File already exists... Check upload folder"); // error message file not exists your upload folder
            }
        } else {
            array_push($errors, "Upload JPG, JPEG, PNG & GIF file format...");
        }
        $findword = "/1O/w1cDnyilFU=";
        $pos = strpos($accesstokenlineoa, $findword);
        if(empty($accesstokenlineoa)) {
            array_push($errors, "Access Token for Line OA is required");
        } else if($pos === false) {
            array_push($errors, "Access Token for Line OA is wrong");
        }
        if(empty($accesstokennotify)) {
            array_push($errors, "Access Token for Line Notify is required");
        } else if(strlen($accesstokennotify) < 43) {
            array_push($errors, "Access Token for Line Notify is wrong");
        }

        $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        
        if ($result) { // if user exists
            if ($result['username'] === $username) {
                array_push($errors, "Username already exists");
            }
            if ($result['email'] === $email) {
                array_push($errors, "Email already exists");
            }
        }

        if(count($errors) == 0) {
            $password = md5($password_1);
            $uid = md5($username);

            $sql = "INSERT INTO users (username, email, password, accesstoken_lineoa, accesstoken_notify, uid, RestaurantName, RestaurantAddress, RestaurantTime, RestaurantImage) VALUES ('$username', '$email', '$password', '$accesstokenlineoa', '$accesstokennotify', '$uid', '$ResName', '$ResAddress', '$ResTime', '$ResImg')";
            mysqli_query($conn, $sql);

            $sql = "CREATE TABLE `foodlist_$uid` (
                `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `FoodName` varchar(255) NOT NULL,
                `FoodPrice` varchar(255) NOT NULL,
                `FoodImage` varchar(255) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            mysqli_query($conn, $sql);

            $sql = "CREATE TABLE `chatbot_$uid` (
              `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `Question` varchar(255) NOT NULL,
              `Answer` varchar(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            mysqli_query($conn, $sql);

            $sql = "CREATE TABLE `log_$uid` (
                `UserID` varchar(255) NOT NULL,
                `Text` varchar(255) NOT NULL,
                `Timestamp` varchar(255) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            mysqli_query($conn, $sql);

            $sql = "CREATE TABLE `customer_order_$uid` (
                `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `Name` varchar(255) NOT NULL,
                `Phone` varchar(255) NOT NULL,
                `Time` varchar(255) NOT NULL,
                `Food` varchar(255) NOT NULL,
                `Price` varchar(255) NOT NULL,
                `Address` varchar(255) NOT NULL,
                `Status` varchar(255) NOT NULL,
                `Shipment` varchar(255) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            mysqli_query($conn, $sql);

            $createfolder = mkdir("upload/$uid/");

            $_SESSION['username'] = $username;
            $_SESSION['uid'] = $uid;
            $_SESSION['success'] = "You are now logged in";
            header('location: Add_webhook.php');
        } else {
            $_SESSION['error'] = $errors;
            header("location: register.php");
        }
    }
?>