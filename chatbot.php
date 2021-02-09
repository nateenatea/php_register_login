<?php
    require_once('server.php');
    session_start();

    if(isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];
        $uid = $_SESSION['uid'];

        $select_stmt = $db->prepare("SELECT * FROM chatbot_$uid WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        // delete an original record from database
        $delete_stmt = $db->prepare("DELETE FROM chatbot_$uid WHERE id = :id");
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:chatbot.php');
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
        <div class="display-3 text-center">Chatbot</div>
    <a href="chatbot_add.php" class="btn btn-success mb-3">Add</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Questions</th>
                    <th>Answers</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $uid = $_SESSION['uid'];
                    $select_stmt = $db->prepare("SELECT * FROM chatbot_$uid");
                    $select_stmt->execute();

                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {                
                ?>
                    <tr>
                        <td><?php echo $row["Question"]; ?></td>
                        <td><?php echo $row["Answer"]; ?></td>
                        <td><a href="chatbot_edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
    <script src="js/bundle.js"></script>
</body>
</html>