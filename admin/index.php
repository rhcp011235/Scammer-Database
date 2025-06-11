<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include '../config.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_scammer'])) {
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
        $stmt = $conn->prepare("INSERT INTO scammers
            (Telegram_Name, Twitter, Name, Whatsapp, Binance_ID, USDT_Address, BTC_Address, Paypal_ID, Email, Notes)
            VALUES (:Telegram_Name, :Twitter, :Name, :Whatsapp, :Binance_ID, :USDT_Address, :BTC_Address, :Paypal_ID, :Email, :Notes)");

        foreach ($data as $key => $value) {
            $stmt->bindParam(":$key", $data[$key]);
        }

        $stmt->execute();
        $message = "Scammer added successfully.";
    } catch (PDOException $e) {
        $message = "Insert failed: " . $e->getMessage();
    }
}

// Fetch scammers
try {
    $stmt = $conn->query("SELECT * FROM scammers ORDER BY id DESC");
    $scammers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Scammers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #1e1e1e;
            color: #f1f1f1;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #00c6ff;
        }

        .logout {
            text-align: center;
            margin-bottom: 20px;
        }

        .logout a {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
            display: block;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #00c6ff;
        }

        tr:nth-child(even) {
            background-color: #2a2a2a;
        }

        form {
            margin-top: 30px;
            padding: 20px;
            background: #2c2c2c;
            border-radius: 10px;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #444;
            border: none;
            color: #fff;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background: #00c6ff;
            cursor: pointer;
        }

        .msg {
            text-align: center;
            margin: 10px 0;
            color: #00c6ff;
        }

        a.edit-link {
            color: #00c6ff;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            th, td, form input, form textarea {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h2>Scammer Records (Admin View)</h2>
    <div class="logout">
        <a href="logout.php">Logout</a> |
        <a href="manage_users.php">Manage Admins</a>
    </div>

    <?php if ($message): ?>
        <div class="msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <h3>Add Scammer Entry</h3>
        <input type="text" name="Telegram_Name" placeholder="Telegram Name" required>
        <input type="text" name="Twitter" placeholder="Twitter">
        <input type="text" name="Name" placeholder="Name">
        <input type="text" name="Whatsapp" placeholder="Whatsapp">
        <input type="text" name="Binance_ID" placeholder="Binance ID">
        <input type="text" name="USDT_Address" placeholder="USDT Address">
        <input type="text" name="BTC_Address" placeholder="BTC Address">
        <input type="text" name="Paypal_ID" placeholder="Paypal ID">
        <input type="email" name="Email" placeholder="Email">
        <textarea name="Notes" placeholder="Notes" rows="3"></textarea>
        <input type="submit" name="add_scammer" value="Add Scammer">
    </form>

    <table>
        <tr>
            <th>Telegram Name</th>
            <th>Twitter</th>
            <th>Name</th>
            <th>Whatsapp</th>
            <th>Binance ID</th>
            <th>USDT Address</th>
            <th>BTC Address</th>
            <th>Paypal ID</th>
            <th>Email</th>
            <th>Notes</th>
            <th>Edit</th>
	    <th>Delete</th>
        </tr>
        <?php foreach ($scammers as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['Telegram_Name']) ?></td>
                <td><?= htmlspecialchars($row['Twitter']) ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['Whatsapp']) ?></td>
                <td><?= htmlspecialchars($row['Binance_ID']) ?></td>
                <td><?= htmlspecialchars($row['USDT_Address']) ?></td>
                <td><?= htmlspecialchars($row['BTC_Address']) ?></td>
                <td><?= htmlspecialchars($row['Paypal_ID']) ?></td>
                <td><?= htmlspecialchars($row['Email']) ?></td>
                <td><?= htmlspecialchars($row['Notes']) ?></td>
                <td><a class="edit-link" href="edit_scammer.php?id=<?= $row['id'] ?>">Edit</a></td>
		<td><a class="edit-link" href="delete_scammer.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this scammer?');">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
