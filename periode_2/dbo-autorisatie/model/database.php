<?php

namespace Databases {

    use PDO;
    use PDOException;

    class Database1
    {
        private $db;

        public function __construct()
        {
            $this->connect();
        }

        private function connect()
        {
            try {
                $this->db = new PDO("mysql:host=localhost;dbname=dbo-autorisatie;charset=utf8mb4", 'root', 'root');
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                return ['error' => "Er heeft zich een probleem voorgedaan bij het verbinden met de database"];
            }
        }

        public function getDb()
        {
            return $this->db;
        }
    }
}
