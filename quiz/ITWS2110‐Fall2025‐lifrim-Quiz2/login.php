<?php
    session_start();
    require "db.php";

    $error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $userId   = trim($_POST['userId']);
        $password = $_POST['password'];

        if ($userId === "" || $password === "") {
            $error = "Please enter both User ID and Password.";
        } else {

            $stmt = $pdo->prepare("SELECT * FROM users WHERE userId = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();

            if (!$user) {
                header("Location: register.php");
                exit;
            }

            $salt = $user['passwordSalt'];
            $expectedHash = hash('sha256', $salt . $password);

            if ($expectedHash !== $user['passwordHash']) {
                $error = "Incorrect Credentials.";
            } else {
                $_SESSION['userId']    = $user['userId'];
                $_SESSION['firstName'] = $user['firstName'];

                header("Location: index.php");
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="./resources/style.css">
    </head>
    <body>
        <div class="container">

        <h1>Login</h1>

        <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="login-form">

            <label>User ID:<br>
                <input type="text" name="userId">
            </label>

            <label>Password:<br>
                <input type="password" name="password">
            </label>

            <button type="submit">Login</button>

        </form>

        </div>
    </body>
</html>
