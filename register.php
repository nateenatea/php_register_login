
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

            <button type="button" id="myBtn">How do I get this Access Token ?</button>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>How to get Access Token for Line OA</p>
                    <?php
                        for ($x = 1 ; $x <= 13 ; $x++) {
                    ?>
                    <img src="TokenGuide/<?php echo $x; ?>.png" width="600" height="300"><br>
                    <p>&nbsp;</p>
                    <?php } ?>
                </div>
            </div>
            <input type="accesstoken" name="accesstokenlineoa">
        </div>
        <div class="input-group">
            <label for="accesstokennotify">Access Token (Line Notify)</label>

            <button type="button" id="myBtn2">How do I get this Access Token ?</button>
            <div id="myModal2" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>How to get Access Token for Line Notify</p>
                    <?php
                        for ($x = 14 ; $x <= 19 ; $x++) {
                    ?>
                    <img src="TokenGuide/<?php echo $x; ?>.png" width="600" height="300"><br>
                    <p>&nbsp;</p>
                    <?php } ?>
                </div>
            </div>

            <script>
            var modal = document.getElementById("myModal");
            var modal2 = document.getElementById("myModal2");
            var btn = document.getElementById("myBtn");
            var btn2 = document.getElementById("myBtn2");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }
            btn2.onclick = function() {
                modal2.style.display = "block";
            }
            span.onclick = function() {
                modal.style.display = "none";
                modal2.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal || event.target == modal2) {
                    modal.style.display = "none";
                    modal2.style.display = "none";
                }
            }
            </script>            

            <input type="accesstoken" name="accesstokennotify">
        </div>
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member ? <a href="login.php">Sign in</a></p>
    </form>
</body>
</html>