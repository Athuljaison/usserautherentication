<?php
include 'db_config.php';

session_start();

$loginMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM userlogin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['username'] = $username;
            header("Location: welcome.php"); // Redirect to a welcome page upon successful login
            exit();
        } else {
            $loginMessage = "Incorrect password!";
        }
    } else {
        $loginMessage = "User not found! Please register.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My BMW Sales Page">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="./css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['username'])) { ?>
            <h2>Login Success</h2>
            <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
            <p>Embark on a clandestine journey through the obsidian veil, where a single click reveals the hidden web of secrets – for those bold enough to seek, the ultimate destination awaits.</p>
        <?php } else { ?>
            <h2>Login</h2>

            <?php if (!empty($loginMessage)) { ?>
                <p><?php echo $loginMessage; ?></p>
            <?php } ?>

            <form action="index.php" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <input type="submit" value="Login">
            </form>

            <p>Are you not registered? Click to register. <a href="index.php">Register here</a></p>
        <?php } ?>
    </div>
</body>
</html>
