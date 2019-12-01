  
<?php

require_once('database.php');
try
{
  $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("SET NAMES 'UTF8'");
	$db->query("DROP DATABASE IF EXISTS camagru");
	$db->query("CREATE DATABASE camagru");
	$db->query("use camagru");

    $db->query("CREATE TABLE `access` (
        `acc_id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `acc_user` varchar(20) UNIQUE KEY NOT NULL,
        `acc_pass` char(255) NOT NULL,
        `acc_salt` char(255) NOT NULL,
        `acc_firstname` varchar(30) NOT NULL,
        `acc_lastname` varchar(30) NOT NULL,
        `acc_phone` varchar(20) NOT NULL,
        `acc_email` varchar(40) NOT NULL,
        `acc_send` int(1) NOT NULL DEFAULT '1',
        `acc_key` varchar(32) NOT NULL,
        `acc_actif` int(1) NOT NULL DEFAULT '0'
      )");

	$db->query("CREATE TABLE `picture` (
        `pic_id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `pic_acc` int(11) NOT NULL,
        `pic_data` varchar(255) NOT NULL,
        `pic_filter` int(11) NOT NULL,
        `pic_date` datetime NOT NULL
      )");
    
    $db->query("CREATE TABLE `comments` (
        `com_id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `com_user` int(11) NOT NULL,
        `com_pic` int(11) NOT NULL,
        `com_data` text NOT NULL,
        `com_date` datetime NOT NULL
      )");
    
    $db->query("CREATE TABLE `likes` (
        `like_id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `like_user` int(11) NOT NULL,
        `like_pic` int(11) NOT NULL
      )");
}
catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

?>