<?php
namespace App\Models;

use App\Classes\User;
use App\Config\DatabaseConnexion;
use PDOException;
use PDO;

class NewUserModel {
    private $connexion;

    public function __construct() {
        $db = new DatabaseConnexion();
        $this->connexion = $db->connect();
    }

    public function addUser($username, $email, $password ,$role,$status) {
        try {
                switch ($role) {
                    case "Teacher":
                        $status = 'Not Activated';
                        break;
                    case "Student":
                        $status = 'Activated';
                        break;
                    default:
                    $status = 'Activated';
                }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, email, password ,role, account_status )
                        VALUES (:username, :email, :password , :role , :account_status );";
            
            

            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':account_status', $status);
            $stmt->execute();

            return $this->connexion->lastInsertId();
        } catch (PDOException $e) {
            return null; 
        }
    }
}
