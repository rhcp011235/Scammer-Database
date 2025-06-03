<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include '../config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_user = trim($_POST['new_username']);
    $new_pass = trim($_POST['new_password']);

    if (strlen($new_user) < 3 || strlen($new_pass) < 6) {
        $message = "Username must be at least 3 chars, password at least 6.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->bindParam(':username', $new_user);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $message = "User already exists.";
            } else {
                $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
                $stmt->bindParam(':username', $new_user);
                $stmt->bindParam(':password', $hash);
                $stmt->execute();
                $message = "User added successfully.";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admin Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #1e1e1e;
            color: #f1f1f1;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #000;
        }

        h2 {
            text-align: center;
            color: #00c6ff;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #444;
            border: none;
            color: #fff;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #00c6ff;
            border: none;
            color: #fff;
            padding: 12px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .msg {
            text-align: center;
            margin-top: 10px;
            color: #ff4d4d;
        }

        .back {
            text-align: center;
            margin-top: 20px;
        }

        .back a {
            color: #00c6ff;
            text-decoration: none;
        }

        @media (max-width: 500px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Admin</h2>
        <form method="post" action="">
            <input type="text" name="new_username" placeholder="New Username" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="submit" value="Create Admin">
        </form>
        <?php if ($message): ?>
            <div class="msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="back">
            <a href="index.php">← Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>
