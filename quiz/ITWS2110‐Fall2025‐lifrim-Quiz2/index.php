<?php
    session_start();
    if (!isset($_SESSION['userId'])) {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="./resources/style.css">
    </head>
    <body>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['firstName']) ?></h1>
        <div class="nav">
            <a href="project.php">Add Project</a></li>
        </div>
        <div class="nav">
            <a href="project.php">View Projects</a></li>
        </div>
    </body>
</html>
