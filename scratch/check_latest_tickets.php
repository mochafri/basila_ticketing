<?php

$host = 'localhost';
$db   = 'basila_ticketing';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $stmt = $pdo->query("SELECT id, judul_permohonan, tiket_status, nip_creator, nama_creator FROM tikets ORDER BY id DESC LIMIT 5");
     $results = $stmt->fetchAll();
     
     echo "ID | Title | Status | NIP Creator | Name Creator\n";
     echo "---|-------|--------|-------------|-------------\n";
     foreach ($results as $row) {
         echo "{$row['id']} | {$row['judul_permohonan']} | {$row['tiket_status']} | {$row['nip_creator']} | {$row['nama_creator']}\n";
     }
     
} catch (\PDOException $e) {
     echo "Database Error: " . $e->getMessage() . "\n";
     exit(1);
}
