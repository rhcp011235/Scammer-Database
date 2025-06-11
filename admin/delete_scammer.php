<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include '../config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Missing or invalid scammer ID.");
}

$id = (int)$_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM scammers WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
} catch (PDOException $e) {
    die("Delete failed: " . $e->getMessage());
}

header("Location: index.php");
exit;

?>
