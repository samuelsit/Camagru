<?php
    $DB_DSN = 'mysql:host=localhost;dbname=camagru';
    $DB_USER = 'root';
    $DB_PASSWORD = 'root';

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
    }