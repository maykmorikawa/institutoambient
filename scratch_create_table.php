<?php
use Cake\Datasource\ConnectionManager;

// Load config
require 'config/bootstrap.php';

$connection = ConnectionManager::get('default');
$sql = "CREATE TABLE IF NOT EXISTS documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    category VARCHAR(50) DEFAULT 'documento', -- 'documento' or 'relatorio'
    created DATETIME,
    modified DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $connection->execute($sql);
    echo "Table 'documents' created successfully.\n";
} catch (\Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
