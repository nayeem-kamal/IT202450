<?php
    include "connect.php";
    include "header.php";
    include "navbar.php";

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="action_style.css">
</head>

<?php
$uname = mysqli_real_escape_string($conn, $_POST["uname"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$pwd = mysqli_real_escape_string($conn, $_POST["cus_pwd"]);

$sql0 = "SELECT MAX(id) FROM users";
$result = $conn->query($sql0);
$row = $result->fetch_assoc();
$id = $row["MAX(id)"] + 1;

$sql3 = "INSERT INTO users (username,email,password) VALUES(
            NULL,
            '$uname',
            '$email',
            '$pwd'
        )";



?>

<body>
    <div class="flex-container">
        <div class="flex-item">
            <?php
            if (($conn->query($sql3) === TRUE)) { ?>
                <p id="info"><?php echo "Customer created successfully !\n"; ?></p>
        </div>

        

        
        

            <?php
            } else { ?>
        </div>
        <div class="flex-item">
                <p id="info"><?php
                echo "Error: " . $sql3 . "<br>" . $conn->error . "<br>"; ?></p>
            <?php } ?>
        </div>
        <?php $conn->close(); ?>

        <div class="flex-item">
            <a href="./customer_add.php" class="button">Add Again</a>
        </div>

    </div>

</body>
</html>
