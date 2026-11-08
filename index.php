<?php
require_once "db.php";

$message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];

            header("Location: dashboard.php");
            exit;

        } else {

            $message = "Invalid email address or password.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <p class="subtitle-top">SESSION AUTHENTICATION</p>

        <h1>Welcome Back!</h1>

        <p class="subtitle">
            Login to your account
        </p>

        <?php if (!empty($message)): ?>

            <div class="message error">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>

        <form method="POST" action="index.php">

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
                placeholder="Enter your password"
                required
            >

            <button type="submit">
                Login →
            </button>

        </form>

        <p class="bottom-text">
            Don't have an account?
            <a href="register.php">Create Account</a>
        </p>

    </div>

</div>

</body>
</html>
