<?php
    session_start();
    require 'db.php';

    if (!isset($_SESSION['userId'])) {
        header("Location: login.php");
        exit;
    }

    $error = "";
    $success = "";
    $newProjectId = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name        = trim($_POST['name'] ?? "");
        $description = trim($_POST['description'] ?? "");
        $members     = $_POST['members'] ?? [];

        if ($name === "" || $description === "") {
            $error = "Project name and description are required.";
        } elseif (count($members) < 3) {
            $error = "Each project must have at least 3 members.";
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE name = ?");
            $stmt->execute([$name]);
            if ($stmt->fetchColumn() > 0) {
                $error = "A project with that name already exists.";
            } else {
                $pdo->beginTransaction();
                try {
                    $stmt = $pdo->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
                    $stmt->execute([$name, $description]);
                    $newProjectId = (int)$pdo->lastInsertId();

                    $pmStmt = $pdo->prepare(
                        "INSERT INTO projectMembership (projectId, memberId) VALUES (?, ?)"
                    );
                    foreach ($members as $mid) {
                        $pmStmt->execute([$newProjectId, $mid]);
                    }

                    $pdo->commit();
                    $success = "Project added successfully.";
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $error = "Error adding project.";
                }
            }
        }
    }

    $usersStmt = $pdo->query(
        "SELECT userId, firstName, lastName, nickName FROM users ORDER BY lastName, firstName"
    );
    $users = $usersStmt->fetchAll();

    $projectsStmt = $pdo->query("
        SELECT p.projectId, p.name, p.description,
            u.userId, u.firstName, u.lastName, u.nickName
        FROM projects p
        LEFT JOIN projectMembership pm ON p.projectId = pm.projectId
        LEFT JOIN users u ON pm.memberId = u.userId
        ORDER BY p.projectId ASC, u.lastName ASC, u.firstName ASC
    ");
    $rows = $projectsStmt->fetchAll();

    $projects = [];
    foreach ($rows as $row) {
        $pid = $row['projectId'];
        if (!isset($projects[$pid])) {
            $projects[$pid] = [
                'projectId'   => $pid,
                'name'        => $row['name'],
                'description' => $row['description'],
                'members'     => []
            ];
        }
        if ($row['userId']) {
            $projects[$pid]['members'][] = $row;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Projects</title>
        <link rel="stylesheet" href="./resources/style.css">
    </head>
    <body>
        <div class="nav">
            <a href="index.php">← Back to Home</a>
        </div>
        <div class="project-page">
            <div class="project-left">
                <div class="form-box">
                    <h2>Add a New Project</h2>

                    <?php if ($error): ?>
                        <p class="error"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <p class="success"><?= htmlspecialchars($success) ?></p>
                    <?php endif; ?>

                    <form method="POST">

                        <label>Project Name:</label>
                        <input type="text" name="name" required>

                        <label>Description:</label>
                        <textarea name="description" required></textarea>

                        <label>Project Members (Hold Ctrl/Cmd to Select Multiple):</label>
                        <select name="members[]" multiple required>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['userId'] ?>">
                                    <?= htmlspecialchars($u['firstName'] . ' ' . $u['lastName'] . ($u['userId'] ? " ({$u['userId']})" : "")) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit">Add Project</button>

                    </form>
                </div>
            </div>

        <div class="project-right">
            
            <h2>Existing Projects</h2>

            <div class="project-list">
                <?php foreach ($projects as $p): ?>
                    <div class="project <?= ($newProjectId == $p['projectId']) ? 'new' : '' ?>">
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>

                        <strong>Members:</strong>
                        <ul>
                            <?php foreach ($p['members'] as $m): ?>
                                <li><?= $m['firstName'] . " " . $m['lastName'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>


    </body>
</html>
