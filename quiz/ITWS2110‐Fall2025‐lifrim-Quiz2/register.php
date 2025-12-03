<?php
    session_start();
    require "db.php";

    $error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $userId   = trim($_POST['userId']);
        $first    = trim($_POST['firstName']);
        $last     = trim($_POST['lastName']);
        $nick     = trim($_POST['nickName']);
        $password = $_POST['password'];
        $confirm  = $_POST['confirmPassword'];

        if ($userId === "" || $first === "" || $last === "" || $password === "" || $confirm === "") {
            $error = "All fields except nickname are required.";
        } elseif ($password !== $confirm) {
            $error = "Passwords do not match.";
        } else {

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE userId = ?");
            $stmt->execute([$userId]);

            if ($stmt->fetchColumn() > 0) {
                $error = "User ID already exists.";
            } else {

                $salt = bin2hex(random_bytes(16));

                $hash = hash('sha256', $salt . $password);

                $stmt = $pdo->prepare("
                    INSERT INTO users (userId, firstName, lastName, nickName, passwordHash, passwordSalt)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([$userId, $first, $last, $nick, $hash, $salt]);

                $_SESSION['userId'] = $userId;
                $_SESSION['firstName'] = $first;

                header("Location: index.php");
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="./resources/style.css">
    </head>
    <body>

        <div class="container">
        <h1>Register</h1>

        <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">

            <label>User ID:<br>
                <input type="text" name="userId" required>
            </label>

            <label>First Name:<br>
                <input type="text" name="firstName" required>
            </label>

            <label>Last Name:<br>
                <input type="text" name="lastName" required>
            </label>

            <label>Nickname:<br>
                <input type="text" name="nickName">
            </label>

            <label>Password:<br>
                <input type="password" name="password" required>
            </label>

            <label>Confirm Password:<br>
                <input type="password" name="confirmPassword" required>
            </label>

            <button type="submit">Register</button>
        </form>
        </div>

    </body>
</html>
