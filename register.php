<?php
require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($username) || empty($email) || empty($password)) {

        $message = "Please fill in all fields.";
        $messageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "error";

    } elseif (strlen($password) < 8) {

        $message = "Password must be at least 8 characters.";
        $messageType = "error";

    } else {

        $check = $conn->prepare(
            "SELECT * FROM users WHERE email = ?"
        );
        $check->execute([$email]);

        if ($check->rowCount() > 0) {

            $message = "Email address is already registered.";
            $messageType = "error";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([
                $username,
                $email,
                $hashedPassword
            ]);

            $message = "Account created successfully!";
            $messageType = "success";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <p class="subtitle-top">SESSION AUTHENTICATION</p>

        <h1>Create Account</h1>

        <p class="subtitle">
            Sign up to get started
        </p>

        <?php if (!empty($message)): ?>

            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>

        <form method="POST" action="register.php">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter your username"
                required
            >

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="name@example.com"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Create a password"
                minlength="8"
                required
            >

            <button type="submit">
                Register →
            </button>

        </form>

        <p class="bottom-text">
            Already have an account?
            <a href="index.php">Login</a>
        </p>

    </div>

</div>

</body>
</html>
