<?php
namespace App\Models;

use App\Classes\User;
use App\Config\DatabaseConnexion;
use PDOException;
use PDO;

class UserModel{
    private $connexion;

    public function __construct() {
            $db = new DatabaseConnexion();
            $this->connexion = $db->connect();
    }

    public function findUser($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
       
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
        if ($row) {
            $passwordDb = $row['password'];
            $hash = password_verify($password, $passwordDb);
       
            if (!$hash) {
                return null;
            } else {
                return new User($row['id'], $row["username"], $row["email"], $row["password"], $row["role"]);
            }
        }
        return null; 
    }
    
    
}