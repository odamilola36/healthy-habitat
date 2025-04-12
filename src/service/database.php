<?php
// /src/Service/Database.php

class Database {
    private static $instance;
    private $db;

    private function __construct() {
        $this->db = new mysqli('127.0.0.1', 'root', '', 'healthy_habitat');

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
        // echo "Connected successfully";
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }
}
