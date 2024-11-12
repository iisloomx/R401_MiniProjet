<?php
class Database {
    private $host = 'localhost';  // L'hôte de la base de données
    private $db_name = 'gestion_equipe_football';  // Le nom de votre base de données
    private $username = 'root';  // Le nom d'utilisateur de votre base de données
    private $password = '';  // Le mot de passe de votre base de données
    public $conn;

    // Méthode pour établir la connexion
    public function getConnection() {
        $this->conn = null;

        try {
            // Création de la connexion PDO avec des options de sécurité
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");  // Définit l'encodage UTF-8
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Active le mode d'erreur d'exception
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  // Désactive l'émulation des requêtes préparées (meilleure sécurité)
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
