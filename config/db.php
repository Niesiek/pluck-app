<?php
    class Database
    {
        private $host = "localhost";
        private $db_name = "pluck";
        private $username = "root";
        private $password = "";
        public $conn;

        public function connect(): PDO
        {
            try {
                $this->conn = new PDO(
                    "mysql:host=$this->host;dbname=$this->db_name",
                    $this->username,
                    $this->password);
                $this -> conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
            return $this->conn;
        }

    }