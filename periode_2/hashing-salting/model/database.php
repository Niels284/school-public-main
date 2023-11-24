<?php

namespace Controller {

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', 1);

    use PDO;
    use PDOException;

    class Database
    {
        protected object $db;

        public function __construct()
        {
            $this->checkDatabaseConnection();
        }

        protected function checkDatabaseConnection() // controleren of de database connectie werkt
        {
            try {
                $this->db = new PDO('mysql:host=localhost;dbname=beveiligd_wachtwoord_db', 'root', 'root');
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function createUser(string $username, string $salt, string $password): array // aanmaken van gebruiker
        {
            $sql = "INSERT INTO gebruiker (GEBRUIKERSNAAM, SALTING, HASH_WACHTWOORD) VALUES (:username, :salt, :password)";
            $stmt = $this->db->prepare($sql);
            try {
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':salt', $salt);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
                return ['success' => 'Account is aangemaakt!'];
            } catch (PDOException) {
                return ['error' => "Er is iets misgegaan, probeer opnieuw!"];
            }
        }

        public function checkLogin(string $username, string $password): array // controleren van login
        {
            $user = $this->getUser($username);
            if (isset($user['error'])) {
                return $user;
            } else if ($user['BLOCKED'] === 1) {
                return ['error' => "Uw account is definitief geblokkeerd! Vraag een medewerker om hulp!"];
            }
            if (password_verify($password . $user['SALTING'], $user['HASH_WACHTWOORD'])) {
                if (!array_key_exists('user', $_SESSION)) {
                    $_SESSION['user'] = [
                        'username' => $user['GEBRUIKERSNAAM'],
                        'id' => $user['ID'],
                    ];
                }
                $this->successLogin($user['ID'], $user['GEBRUIKERSNAAM'], $user['AANTAL_LOGINS']);
                return ['success' => "U bent ingelogd! U wordt nu doorgestuurd naar de homepagina!"];
            } else {
                if (!array_key_exists('failedLogin', $_SESSION)) {
                    $_SESSION['failedLogin'] = 1;
                } else if ($_SESSION['failedLogin'] >= 3) {
                    $this->failedLogin($user['ID'], $user['GEBRUIKERSNAAM']);
                    unset($_SESSION['failedLogin']);
                    return ['error' => "Uw account is definitief geblokkeerd! Vraag een medewerker om hulp!"];
                } else {
                    $_SESSION['failedLogin']++;
                }
                return ['error' => "Ongeldige gebruikersnaam of wachtwoord!"];
            }
        }

        protected function getUser(string $username) // controleren of de gebruiker bestaat
        {
            $sql = "SELECT * FROM gebruiker WHERE GEBRUIKERSNAAM = :username LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            try {
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetch();
                } else {
                    return ['error' => "Gebruiker bestaat niet!"];
                }
            } catch (PDOException) {
                return ['error' => "Er is iets misgegaan, probeer het opnieuw!"];
            }
        }

        protected function successLogin(string $id, string $username, $aantalLogins) // registreren van login
        {
            if ($aantalLogins === null) {
                $logins = 1;
            } else {
                $logins = $aantalLogins + 1;
            }
            $sql = "UPDATE gebruiker SET AANTAL_LOGINS = :aantalLogins, LAATSTE_LOGIN = NOW() WHERE ID = :id AND GEBRUIKERSNAAM = :username LIMIT 1";
            $stmt = $this->db->prepare($sql);
            try {
                $stmt->bindParam(':aantalLogins', $logins);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
            } catch (PDOException) {
                return ['error' => "Er is iets misgegaan, probeer het opnieuw!"];
            }
        }

        protected function failedLogin(string $id, string $username) // blokkeren van gebruiker
        {
            $sql = "UPDATE gebruiker SET BLOCKED = 1 WHERE ID = :id AND GEBRUIKERSNAAM = :username LIMIT 1";
            $stmt = $this->db->prepare($sql);
            try {
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
            } catch (PDOException) {
                return ['error' => "Er is iets misgegaan, probeer het opnieuw!"];
            }
        }
    }
}
