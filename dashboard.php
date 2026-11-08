<?php
require_once "db.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

// Get user information
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$session_id = session_id();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | SessionAuthSystem</title>

    <link rel="stylesheet" href="style.css">
</head>

<body class="dashboard-body">

    <!-- NAVIGATION BAR -->
    <nav class="navbar">

        <div class="nav-brand">
            
            SessionAuthSystem
            <span>Dashboard</span>
        </div>

        <div class="nav-actions">

            <span>
                <?php echo htmlspecialchars($username); ?>
            </span>

            <a href="logout.php" class="logout-link">
                Logout
            </a>

        </div>

    </nav>


    <!-- MAIN DASHBOARD -->
    <main class="dashboard-wrap">

        <!-- WELCOME SECTION -->
        <section class="welcome-panel">

            <div>

                <p class="eyebrow light">
                    YOUR PERSONAL SPACE
                </p>

                <h1>
                    Welcome, <?php echo htmlspecialchars($username); ?>!
                </h1>

                <p>
                    This page is protected and only visible to logged-in users.
                </p>

                <a href="#account-details" class="btn btn-light">
                    Explore Dashboard
                </a>

            </div>

            <div class="welcome-decoration">
                ✦
            </div>

        </section>


        <!-- DASHBOARD DETAILS -->
        <section class="dashboard-grid" id="account-details">


            <!-- ACCOUNT STATUS -->
            <article class="info-card">

                <div class="card-icon green-icon">✓</div>

                <p class="card-label">
                    Account Status
                </p>

                <h2>Active</h2>

                <p class="card-note">
                    Your session is active and protected against
                    Session Fixation using
                    <code>session_regenerate_id(true)</code>.
                </p>

            </article>


            <!-- USER DETAILS -->
            <article class="info-card">

                <div class="card-icon blue-icon">♙</div>

                <p class="card-label">
                    User Details
                </p>

                <p class="card-note">
                    <strong>User ID:</strong>
                    <?php echo htmlspecialchars((string)$user_id); ?>
                </p>

                <p class="card-note">
                    <strong>Username:</strong>
                    <?php echo htmlspecialchars($username); ?>
                </p>

            </article>


            <!-- ACTIVE SESSION ID -->
            <article class="info-card">

                <div class="card-icon purple-icon">◷</div>

                <p class="card-label">
                    Active Session ID
                </p>

                <p class="card-note">
                    <strong>Current Session ID:</strong>
                </p>

                <p class="card-note">
                    <?php echo htmlspecialchars($session_id); ?>
                </p>

                <p class="card-note">
                    Generated after login call to
                    session_regenerate_id(true).
                </p>

            </article>


        </section>
            <div class="dashboard-notice">

    <div class="notice-content">

        <span class="info-icon">ⓘ</span>

        <span>
            This is a demo dashboard. You can log out and log back in to use session registration in action.
        </span>

    </div>

</div>

    </main>

</body>
</html>
