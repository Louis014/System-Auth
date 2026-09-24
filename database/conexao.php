<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$_SESSION["conexao_bd"] = 0;

$host = 'localhost'; 
$db   = 'system_auth';
$user = 'luis';
$pass = 'cimatec';

try {
$pdo = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
$_SESSION["conexao_bd"] = 1;
} catch (\PDOException $e) {
    $_SESSION["conexao_bd"] = 0;
}