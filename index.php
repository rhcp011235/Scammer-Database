<?php
include 'config.php';

// Fetch scammers
try {
    $stmt = $conn->query("SELECT * FROM scammers ORDER BY id DESC");
    $scammers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Fetch admin usernames
try {
    $stmt = $conn->query("SELECT username FROM users ORDER BY id ASC");
    $admins = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $admins = [];
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Scammer Data</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
        body { font-family: Arial; background: #1e1e1e; color: #f1f1f1; padding: 20px; }
        h2 { text-align: center; color: #00c6ff; }
        .desktop-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .desktop-table th, .desktop-table td { border: 1px solid #444; padding: 10px; text-align: left; }
        .desktop-table th { background: #333; color: #00c6ff; }
        .desktop-table tr:nth-child(even) { background: #2a2a2a; }

        .mobile-card { display: none; margin-top: 20px; }
        .card { background: #2a2a2a; padding: 15px; margin-bottom: 15px; border-radius: 10px; border: 1px solid #444; }
        .card-label { font-weight: bold; color: #00c6ff; }

        .admin-section { margin-top: 30px; padding-top: 10px; border-top: 1px solid #333; text-align: center; }
        .admin-section ul { list-style: none; padding: 0; margin: 10px 0 20px 0; }
        .admin-section li { color: #00c6ff; }

        footer { text-align: center; font-size: 14px; margin-top: 30px; padding-top: 10px; border-top: 1px solid #444; color: #888; }

        @media (max-width: 768px) {
            .desktop-table { display: none; }
            .mobile-card { display: block; }
        }
    </style>
</head>
<body>
<h2>Scammer Information</h2>

<table class='desktop-table'>
<tr>
<th>Telegram Name</th><th>Twitter</th><th>Name</th><th>Whatsapp</th><th>Binance ID</th><th>USDT Address</th>
<th>BTC Address</th><th>Paypal ID</th><th>Email</th><th>Notes</th>
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
</tr>
<?php endforeach; ?>
</table>

<div class='mobile-card'>
<?php foreach ($scammers as $row): ?>
<div class='card'>
<p><span class='card-label'>Telegram:</span> <?= htmlspecialchars($row['Telegram_Name']) ?></p>
<p><span class='card-label'>Twitter:</span> <?= htmlspecialchars($row['Twitter']) ?></p>
<p><span class='card-label'>Name:</span> <?= htmlspecialchars($row['Name']) ?></p>
<p><span class='card-label'>Whatsapp:</span> <?= htmlspecialchars($row['Whatsapp']) ?></p>
<p><span class='card-label'>Binance:</span> <?= htmlspecialchars($row['Binance_ID']) ?></p>
<p><span class='card-label'>USDT:</span> <?= htmlspecialchars($row['USDT_Address']) ?></p>
<p><span class='card-label'>BTC:</span> <?= htmlspecialchars($row['BTC_Address']) ?></p>
<p><span class='card-label'>Paypal:</span> <?= htmlspecialchars($row['Paypal_ID']) ?></p>
<p><span class='card-label'>Email:</span> <?= htmlspecialchars($row['Email']) ?></p>
<p><span class='card-label'>Notes:</span> <?= nl2br(htmlspecialchars($row['Notes'])) ?></p>
</div>
<?php endforeach; ?>
</div>

<div class='admin-section'>
<h3>Provided by your Admins:</h3>
<ul>
<?php foreach ($admins as $admin): ?>
<li><?= htmlspecialchars($admin) ?></li>
<?php endforeach; ?>
</ul>
</div>

<footer>Made by @rhcp011235 · Copyright 2025</footer>
</body>
</html>
