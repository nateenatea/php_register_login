<?php
    require_once('server.php');
    session_start();

    if(!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must login first";
        header('location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="Home.php">Home</a>
            <ul class = "bg-dark">
                <a class="navbar-brand" href="DataTable.php">Food List</a>
                <a class="navbar-brand" href="order_page.php">Orders</a>
                <a class="navbar-brand" href="chatbot.php">Chatbot</a>
                <a class="navbar-brand" href="log.php">Chat history</a>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php if(isset($_SESSION['username'])) : ?>
            <p>
                Admin: <strong><?php echo $_SESSION['username']; ?></strong>&nbsp;
                UID: <strong><?php echo $_SESSION['uid']; ?></strong>&nbsp;
                <a href="index.php?logout='1'" style="color: red;">Logout</a> 
            </p>
        <?php endif ?>
    <!-- <div class="display-3 text-center">Admin</div> -->
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Restaurant Name</th>
                    <th>Restaurant Address</th>
                    <th>Open-Close Time</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $uid = $_SESSION['uid'];
                    $select_stmt = $db->prepare("SELECT * FROM users WHERE `uid` = '$uid'");
                    $select_stmt->execute();

                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {                
                ?>
                    <tr>
                        <td><?php echo $row["RestaurantName"]; ?></td>
                        <td><?php echo $row["RestaurantAddress"]; ?></td>
                        <td><?php echo $row["RestaurantTime"]; ?></td>
                        <td><img src="upload/<?php echo $row['RestaurantImage'];?>" width="100px" height="100px" alt=""></td>
                        <td><a href="Home_edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>