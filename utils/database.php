<?php 
    require_once __DIR__ . '/../config/config.php';

    class Database {
        private $connection;
    
        public function __construct() {
            $this->connect();
        }
    
        private function connect() {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }
    
        public function getConnection() {
            return $this->connection;
        }
    }
?>