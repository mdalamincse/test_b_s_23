<?php


namespace App;


use PDO;

class DB
{
    private $username;
    private $password;
    private $db_name;
    private static $conn;


    public function __construct($username = 'root', $password = 'BDhaka@19', $db_name = 'ecommerce')
    {
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;
    }

    public function connect(): PDO
    {

        if (!self::$conn instanceof PDO) {
            $username = $this->username;
            $password = $this->password;
            $database = $this->db_name;

            $dsn = 'mysql:host=localhost;dbname=' . $database;

            self::$conn = new PDO($dsn, $username, $password);
        }
        return self::$conn;
    }

    public function itemList(string $sql)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}