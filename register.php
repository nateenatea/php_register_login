
<?php 
    session_start();
    include('server.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Register</h2>
    </div>
    
    <form action="register_db.php" method="post">
        <?php include('errors.php'); ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php
                        foreach ($_SESSION['error'] as $errors) {
                            echo "$errors <br>"; 
                        } 
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <label for="password_1">Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label for="password_2">Comfirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <label for="accesstokenlineoa">Access Token (Line OA)</label>
            <a type="button" href="OA_TokenGuide.php" target="_blank">How do I get this Access Token ?</a>
            <input type="accesstoken" name="accesstokenlineoa">
        </div>
        <div class="input-group">
            <label for="accesstokennotify">Access Token (Line Notify)</label>     
            <a type="button" href="Notify_TokenGuide.php" target="_blank">How do I get this Access Token ?</a>
            <input type="accesstoken" name="accesstokennotify">
        </div>
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member ? <a href="login.php">Sign in</a></p>
    </form>
</body>
</html>