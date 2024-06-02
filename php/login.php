<?php
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include 'db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query to get user details
    $stmt = $conn->prepare('SELECT user_id, password FROM Users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    // Verify password
    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        header('Location: main.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo '<p class="error">' . $error . '</p>'; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="../register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
