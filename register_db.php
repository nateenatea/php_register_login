<?php
    session_start();
    include('server.php');

    $errors = array();

    if(isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
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

            $sql = "INSERT INTO users (username, email, password, accesstoken_lineoa, accesstoken_notify, uid) VALUES ('$username', '$email', '$password', '$accesstokenlineoa', '$accesstokennotify', '$uid')";
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