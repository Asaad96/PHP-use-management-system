
<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);


$use_mysql = true;

if ($use_mysql) {
    // --- MySQL Configuration ---
    $DB_HOST = '127.0.0.1';
    $DB_NAME = 'auth_demo';
    $DB_USER = 'Asaad'; 
    $DB_PASS = 'A12345@php'; 
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$charset}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
    } catch (PDOException $e) {
        exit('Database connection failed: ' . $e->getMessage());
    }
} else {
    // --- SQLite Alternative --- (for local quick testing)
    $dbFile = __DIR__ . '/../data/auth_demo.sqlite';
    if (!is_dir(__DIR__ . '/../data')) {
        mkdir(__DIR__ . '/../data', 0755, true);
    }

    $dsn = 'sqlite:' . $dbFile;

    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Auto-create users table if not exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            phone TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );");
    } catch (PDOException $e) {
        exit('SQLite connection failed: ' . $e->getMessage());
    }
}
