<?php
    require_once('server.php');
    session_start();

    if(isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];
        $uid = $_SESSION['uid'];

        $select_stmt = $db->prepare("SELECT * FROM foodlist_$uid WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        unlink("upload/".$row['FoodImage']); //unlink function permanently remove your file

        // delete an original record from database
        $delete_stmt = $db->prepare("DELETE FROM foodlist_$uid WHERE id = :id");
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:DataTable.php');
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
                <a href="index.php?logout='1'" style="color: red;">Logout</a> 
            </p>
        <?php endif ?>
    <div class="display-3 text-center">Food List</div>
    <?php echo $_SESSION['uid']?>
    <a href="add.php" class="btn btn-success mb-3">Add</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Food Name</th>
                    <th>Food Price</th>
                    <th>Food Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $uid = $_SESSION['uid'];
                    $select_stmt = $db->prepare("SELECT * FROM foodlist_$uid");
                    $select_stmt->execute();

                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {                
                ?>
                    <tr>
                        <td><?php echo $row["FoodName"]; ?></td>
                        <td><?php echo $row["FoodPrice"]; ?></td>
                        <td><img src="upload/<?php echo $row['FoodImage'];?>" width="100px" height="100px" alt=""></td>
                        <td><a href="edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
    
    <script src="js/bundle.js"></script>
</body>
</html>