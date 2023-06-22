<?php
include_once 'config/config.php';

class Database
{
    public static function StartUp()
    {
        $pdo = new PDO('mysql:host='.DATABASE_CONFIG["HOST__DB"].';dbname='.DATABASE_CONFIG["NAME__DB"].';charset='.DATABASE_CONFIG["CHARSET__DB"], DATABASE_CONFIG["USER__DB"], DATABASE_CONFIG["PASSWORD__DB"]);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}