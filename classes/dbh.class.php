<?php

    class DBH {
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $dbname = "chatapp";

        public $conn = null;

        public function __construct(){
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

            if (!$this->conn) {
                die("Connection Failed: ".mysqli_connect_error());
            }
        }

        public function __destruct(){
            $this->destroyConnection();
        }

        public function destroyConnection() {
            if ($this->conn !== null) {
                $this->conn->close();
                $this->conn = null;
            }
        }
    }