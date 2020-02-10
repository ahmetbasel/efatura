<?php 
$hostname	='localhost';
$username	='root';
$dbname		='efatura';
$password	='';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname",$username,$password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
	$pdo->exec("set names utf8");

?>