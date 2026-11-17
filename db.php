<?php

session_start();

$dbPath = __DIR__ . '/task_db.db';

try {
    $pdo = new PDO("sqlite:" . $dbPath);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Enable foreign key constraints
    $pdo->exec("PRAGMA foreign_keys = ON");

} catch (PDOException $e) {
    die("Database connection failed");
}
?>