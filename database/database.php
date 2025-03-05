<?php

    class database {
        private $severname = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "webBanGiay";
        private $conn;
        public function __construct() {
            $this->conn = new mysqli($this->severname, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        public function selectAll ($sql) {
            $result = $this->conn->query($sql);
            return $result;
        }

        public function selectBy ($sql,$args) {
            $pst = $this->conn->prepare($sql);

            // get type of data
            $type = "";
            foreach ($args as $key => $value) {
                switch (gettype($value)) {
                    case "integer":
                        $type .= "i";
                        break;
                    case "double":
                        $type .= "d";
                        break;
                    case "string":
                        $type .= "s";
                        break;
                }
            }

            $val = [];
            foreach ($args as $key => $value) {
                $val[] = &$args[$key];
            }

            $pst->bind_param($type, ...$val);
            $pst->execute();

            if ($pst->error) {
                die($pst->error);
            }

            $result = $pst->get_result();
            $pst->close();

            return $result;

        }

        public function insert ($sql) {
            $this->conn->query($sql);
            return $this->conn->insert_id;
        }

        public function update ($sql) {
            $this->conn->query($sql);
            return $this->conn->affected_rows;
        }

        public function delete ($sql) {
            $this->conn->query($sql);
            return $this->conn->affected_rows;
        }
    }

?>