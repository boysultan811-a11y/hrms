<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    echo "MySQL connection: SUCCESS\n";

    $databases = $pdo->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN);
    if (in_array('hrms', $databases)) {
        echo "Database 'hrms': EXISTS\n";
    } else {
        echo "Database 'hrms': NOT FOUND\n";
        echo "Creating database 'hrms'...\n";
        $pdo->exec('CREATE DATABASE IF NOT EXISTS hrms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        echo "Database 'hrms' created successfully!\n";
    }
} catch (Exception $e) {
    echo 'MySQL connection: FAILED - '.$e->getMessage()."\n";
}


