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
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="DataTable.php">Home</a>
            <ul class = "bg-dark">
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
    <div class="display-3 text-center">Orders List</div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Time</th>
                    <th>Address</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $uid = $_SESSION['uid'];
                    $select_stmt = $db->prepare("SELECT * FROM customer_order_$uid");
                    $select_stmt->execute();

                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {                
                ?>
                    <tr>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["Phone"]; ?></td>
                        <td><?php echo $row["Time"]; ?></td>
                        <td><?php echo $row["Address"]; ?></td>
                        <td><?php echo $row["Food"]; ?></td>
                        <td><?php echo $row["Price"]; ?></td>
                        <td><?php echo $row["Status"]; ?></td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>

    <script src="js/bundle.js"></script>
</body>
</html>