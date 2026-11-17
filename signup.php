<?php

require_once 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([':username' => $username, ':password' => $hashedPassword]);

        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        $error = "Username already exists or signup failed.";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>

    <h2>Sign Up</h2>

    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>

    <form method="POST" action="signup.php">

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br><br>

        <button type="submit">Sign Up</button>

    </form>

    <a href="login.php">Already have an account? Login</a>

</body>
</html>