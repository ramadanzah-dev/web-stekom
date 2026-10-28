<?php
$c = require __DIR__ . '/config/database.php';
try {
    $pdo = new PDO("mysql:host={$c['host']};port={$c['port']};dbname={$c['database']};charset={$c['charset']}", $c['username'], $c['password']);
    echo "OK: " . $pdo->query('SELECT VERSION()')->fetchColumn();
} catch (Throwable $e) {
    echo "Gagal: " . $e->getMessage();
}