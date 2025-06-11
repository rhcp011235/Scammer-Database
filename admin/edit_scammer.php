<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include '../config.php';

if (!isset($_GET['id'])) {
    die("Missing scammer ID.");
}

$id = (int)$_GET['id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'Telegram_Name', 'Twitter', 'Name', 'Whatsapp',
        'Binance_ID', 'USDT_Address', 'BTC_Address',
        'Paypal_ID', 'Email', 'Notes'
    ];

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = trim($_POST[$field] ?? '');
    }

    try {
        $sql = "UPDATE scammers SET
            Telegram_Name = :Telegram_Name, Twitter = :Twitter, Name = :Name,
            Whatsapp = :Whatsapp, Binance_ID = :Binance_ID, USDT_Address = :USDT_Address,
            BTC_Address = :BTC_Address, Paypal_ID = :Paypal_ID, Email = :Email, Notes = :Notes
            WHERE id = :id";
        $stmt = $conn->prepare($sql);
        foreach ($data as $key => $val) {
            $stmt->bindParam(":$key", $data[$key]);
        }
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $message = "Scammer updated successfully.";
    } catch (PDOException $e) {
        $message = "Update failed: " . $e->getMessage();
    }
}

$stmt = $conn->prepare("SELECT * FROM scammers WHERE id = ?");
$stmt->execute([$id]);
$scammer = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$scammer) {
    die("Scammer not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Scammer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #1e1e1e;
            color: #f1f1f1;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #00c6ff;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #444;
            border: none;
            color: white;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: #00c6ff;
            cursor: pointer;
        }

        .msg {
            color: #00c6ff;
            text-align: center;
        }

        a {
            color: #00c6ff;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Scammer Record</h2>
        <?php if ($message): ?>
            <div class="msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post">
            <?php foreach ($scammer as $key => $value): if ($key === 'id') continue; ?>
                <?php if ($key === 'Notes'): ?>
                    <textarea name="<?= $key ?>" rows="3" placeholder="<?= $key ?>"><?= htmlspecialchars($value) ?></textarea>
                <?php else: ?>
                    <input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" placeholder="<?= $key ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <input type="submit" value="Save Changes">
        </form>
        <a href="index.php">← Back to Admin Panel</a>
    </div>
</body>
</html>
