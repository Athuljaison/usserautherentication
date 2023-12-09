<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_config.php';

function registerUser($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Remove the "Form submitted!" echo statement
        $username = $_POST['username'];
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO userlogin (username, password_hash, email) VALUES (?, ?, ?)";

        // Print the SQL query for debugging
        echo "SQL Query: $sql <br>";

        $stmt = $conn->prepare($sql);

        // Check if the prepare statement was successful
        if ($stmt) {
            $stmt->bind_param("sss", $username, $password_hash, $email);

            if ($stmt->execute()) {
                echo '<div class="success-message">Registration successful!</div>';
            } else {
                // Check for duplicate entry error
                if ($stmt->errno == 1062) {
                    echo "Error: Duplicate entry for username or email.";
                } else {
                    echo "Execution Error: " . $stmt->error;
                }
            }

            $stmt->close();
        } else {
            echo "Prepare Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Main registration form container -->
    <div class="container">
        <!-- Registration title -->
        <h2 class="title">Register</h2>

        <!-- Registration form -->
        <form method="post">
            <!-- Username input -->
            <label for="username" class="label">Username</label>
            <input type="text" id="username" name="username" required="required" class="input">

            <!-- Email input -->
            <label for="email" class="label">Email</label>
            <input type="email" id="email" name="email" required="required" class="input">

            <!-- Password input -->
            <label for="password" class="label">Password</label>
            <input type="password" id="password" name="password" required="required" class="input">

            <!-- Registration submit button -->
            <button type="submit" class="submit">Register</button>
        </form>

        <!-- Link to login page -->
        <p class="link">Already have an account? <a href="./login.php">Login here</a>.</p>
    </div>
</body>
</html>
