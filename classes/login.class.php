<?php

    class LOGIN extends DBH {
        public function checkUserExistence($email, $table = "users"){
            if ($this->conn !== null) {
                if (isset($email)) {
                    $sql = "SELECT * FROM {$table} WHERE email=? LIMIT 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("s", $email);
                    
                    if ($stmt->execute()){
                        $result = $stmt->get_result();
                        $check = $result->num_rows;

                        if ($check > 0) {
                            $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            return $data;
                        }
                    }
                }
            }
        }
    }