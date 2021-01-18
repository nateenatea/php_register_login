<?php
    require_once('server.php');
    session_start();
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
    <ul class="ul">
        <li class="li"><a href="DataTable.php">Home</a></li>
        <li style="float:right"><a class="active" href="log.php">Chat history</a></li>
    </ul>
    <div class="container">
        <?php if(isset($_SESSION['username'])) : ?>
            <p>
                Admin: <strong><?php echo $_SESSION['username']; ?></strong>&nbsp;
                <a href="index.php?logout='1'" style="color: red;">Logout</a> 
            </p>
        <?php endif ?>
    <div class ="display-3 text-center">Chat History</div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Text</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $select_stmt = $db->prepare("SELECT * FROM log");
                    $select_stmt->execute();

                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?php echo $row["UserID"] ?></td>
                        <td><?php echo $row["Text"] ?></td>
                        <td><?php echo $row["Timestamp"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="js/bundle.js"></script>
</body>
</html>