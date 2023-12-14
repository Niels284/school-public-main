<?php

// CRUD functies
namespace Controllers {

    use Databases\Database1;
    use PDO;
    use PDOException;

    include_once '../../model/database.php';

    class Controller1
    {
        private object $db;

        public function __construct()
        {
            try {
                $db = new Database1();
                $this->db = $db->getDb();
            } catch (PDOException $e) {
                return ['error' => 'Er heeft zich een probleem voorgedaan bij het verbinden met de database'];
            }
        }

        public function login(string $username, string $password): array // login method
        {
            try {
                $query = $this->db->prepare("SELECT * FROM gebruikers WHERE gebruikersnaam = :gebruikersnaam");
                $query->execute([
                    'gebruikersnaam' => $username,
                ]);
                $user = $query->fetch(PDO::FETCH_ASSOC);
                if ($query->rowCount() > 0) {
                    if (password_verify($password, $user['wachtwoord'])) {
                        if ($user['rechten_niveau'] <= 0) {
                            return ['error' => 'Uw account is geblokkeerd, vraag een beheerder om hulp!'];
                        }
                        return $user;
                    } else {
                        return ['error' => 'Ongeldige gebruikersnaam en/of wachtwoord'];
                    }
                } else {
                    return ['error' => 'Gebruiker bestaat niet'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Poging tot inloggen is mislukt, probeer het opnieuw'];
            }
        }

        public function getUsers(): array // getUsers method
        {
            try {
                $query = $this->db->prepare("SELECT * FROM gebruikers");
                $query->execute();
                $user = $query->fetchAll(PDO::FETCH_ASSOC);
                if ($query->rowCount() > 0) {
                    return $user;
                } else {
                    return ['error' => 'Er zijn geen gebruikers gevonden'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Er heeft zich een probleem voorgedaan bij het ophalen van de gebruikers'];
            }
        }

        public function getUser(int $id): array // getUser method
        {
            try {
                $query = $this->db->prepare("SELECT * FROM gebruikers WHERE id = :id");
                $query->execute([
                    'id' => $id
                ]);
                $user = $query->fetch(PDO::FETCH_ASSOC);
                if ($query->rowCount() > 0) {
                    return $user;
                } else {
                    return ['error' => 'Er zijn geen gebruikers gevonden'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Er heeft zich een probleem voorgedaan bij het ophalen van de gebruiker'];
            }
        }

        public function createUser(string $username, string $password, int $level): array // createUser method
        {
            foreach ($this->getUsers() as $user) {
                if ($user['gebruikersnaam'] === $username) {
                    return ['error' => 'Gebruikersnaam is al in gebruik, probeer een andere gebruikersnaam'];
                }
            }
            try {
                $query = $this->db->prepare("INSERT INTO gebruikers (gebruikersnaam, wachtwoord, rechten_niveau) VALUES (:gebruikersnaam, :wachtwoord, :rechten_niveau)");
                $query->execute([
                    'gebruikersnaam' => $username,
                    'wachtwoord' => password_hash($password, PASSWORD_DEFAULT),
                    'rechten_niveau' => $level // standaard rechten_niveau is 1
                ]);
                if ($query->rowCount() > 0) {
                    return ['success' => 'Gebruiker is aangemaakt'];
                } else {
                    return ['error' => 'Er is mogelijk iets misgegaan bij het aanmaken van de gebruiker'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Er is iets misgegaan bij het aanmaken van de gebruiker'];
            }
        }

        public function updateUser(int $id, string $username, string $password, int $level): array // updateUser method
        {
            try {
                $query = $this->db->prepare("UPDATE gebruikers SET gebruikersnaam = :gebruikersnaam, wachtwoord = :wachtwoord, rechten_niveau = :rechten_niveau WHERE id = :id");
                $query->execute([
                    'id' => $id,
                    'gebruikersnaam' => $username,
                    'wachtwoord' => password_hash($password, PASSWORD_DEFAULT),
                    'rechten_niveau' => $level
                ]);
                if ($query->rowCount() > 0) {
                    return ['success' => 'Gebruiker is aangepast'];
                } else {
                    return ['error' => 'Er is mogelijk iets misgegaan bij het aanpassen van de gebruiker'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Er is iets misgegaan bij het aanpassen van de gebruiker'];
            }
        }

        public function deleteUser(int $id): array // deleteUser method
        {
            try {
                $query = $this->db->prepare("DELETE FROM gebruikers WHERE id = :id");
                $query->execute([
                    'id' => $id
                ]);
                if ($query->rowCount() > 0) {
                    return ['success' => 'Gebruiker is verwijderd'];
                } else {
                    return ['error' => 'Er is mogelijk iets misgegaan bij het verwijderen van de gebruiker'];
                }
            } catch (PDOException $e) {
                return ['error' => 'Er is iets misgegaan bij het verwijderen van de gebruiker'];
            }
        }
    }
}
