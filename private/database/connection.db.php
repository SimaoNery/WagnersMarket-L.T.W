<?php
declare(strict_types=1);

function getDatabaseConnection(): PDO {
    $dbFile = __DIR__ . '/database.db'; 
    try {
        $db = new PDO('sqlite:' . $dbFile);
        
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    } catch (PDOException $e) {  
        die('Database connection failed: ' . $e->getMessage());
    }
}
?>
