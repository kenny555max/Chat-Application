<?php

    class SIGNUP {
        public $conn = null;

        public function __construct(DBH $dbh){
            if ($dbh->conn === null) return;

            $this->conn = $dbh->conn;
        }

        public function checkIfUserAlreadyExist($email, $table = "users") {
            if ($this->conn !== null) {
                if (isset($email)) {
                    $sql = "SELECT * FROM {$table} WHERE email=? LIMIT 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $check = $result->num_rows;

                    return $check;
                }
            }
        }

        public function insertUserData($param, $table = "users") {
            if ($this->conn !== null) {
                if ($param !== null) {
                    // get array keys
                    $array_keys = array_keys($param);
                    // get array values
                    $array_values = array_values($param);

                    $sql = "INSERT INTO {$table}";
                    $sql .= "(`".implode("`,`", $array_keys)."`)";
                    $sql .= " VALUES('".implode("','", $array_values)."')";
                    $result = mysqli_query($this->conn, $sql);
                    
                    if ($result) {
                        $_SESSION['id'] = $this->conn->insert_id;

                        return true;
                    }
                }
            }
        }
    }