<?php
$hosts = ['127.0.0.1', 'localhost'];
$passwords = ['', 'root', 'admin', 'password', '123456'];

foreach ($hosts as $host) {
    foreach ($passwords as $password) {
        try {
            echo "Trying host=$host, user=root, password='$password'...\n";
            $pdo = new PDO("mysql:host=$host;port=3306", 'root', $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS yemen_souq");
            echo "SUCCESS: Database created using host=$host and password='$password'.\n";
            exit(0);
        } catch (PDOException $e) {
            echo "Failed: " . $e->getMessage() . "\n";
        }
    }
}
echo "All attempts failed.\n";
exit(1);
