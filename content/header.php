<?php
//starting a session if one doesn't exist for login/logout functions as well as tracking the users session.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <title>Smartphone Recommendation Site</title>

        <!-- Bootstrap CSS for layout/styling-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

        <!-- Google Font Poppins for cleaner UI -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    
    <body>
        <!-- Navigation bar which adapts to login status -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- Adding a logo and a site name to the header which links to index page if clicked. -->
                <a class="navbar-brand d-flex align-items-center gap-2" href="/4222COMP/content/index.php">
                    <img src ="/4222COMP/images/iphone.png" alt="Logo" height="32" class="d-inline-block align-text-top">
                    <span>Smartphone Recommendation</span>
                </a>
                
                <!-- Mobile menu button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <!-- Navigation links -->
            <div class="collapse navbar-collapse d-flex justify-content-between align-items-center" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/4222COMP/content/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/4222COMP/content/rankings.php">Rankings</a></li>

                    <!-- Adding registration/login links if user is not logged in. -->
                    <?php if (!isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="/4222COMP/content/register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="/4222COMP/content/login.php">Login</a></li>

                    <!-- Adding an account page link if the user is logged in -->
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/4222COMP/content/account.php">Account</a></li>
                    <?php endif; ?>
                </ul>

            <!-- Displaying username and creating a logout button if user is logged in -->
            <?php if (isset($_SESSION['username'])): ?>
                <span class="navbar-text text-white me-3">
                    Logged in as <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                </span>
                <a class="btn btn-outline-light btn-sm" href="/4222COMP/content/logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Main page content -->
<main class="flex-grow-1 container my-4">