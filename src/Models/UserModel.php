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
        $query = "SELECT * FROM users 
        WHERE users.email = :email";
    
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $passwordDb = $row['password'];
    
            $verfiy = password_verify($password, $passwordDb);
    
            if(!$verfiy){
                return null;
            }
            else{   
                return new User($row['id'],$row["username"],$row["email"],$row["password"],$row["role"],$row["account_status"]);
            }
    
        } else {
            return null; 
        }
    }

    public function updateUserStatus($userId, $newStatus) {
        try {
            $query = "UPDATE Users SET account_status = :newStatus WHERE id = :userId";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':newStatus', $newStatus);
            $stmt->bindParam(':userId', $userId);
            return $stmt->execute(); 
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage()); 
            return false; 
        }
    }
    
    public function getUsers($status = null) {
        $query = "SELECT * FROM Users";
        if ($status) {
            $query .= " WHERE account_status = :status"; 
        }
        $stmt = $this->connexion->prepare($query);
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeUser($userId) {
    
        $sql = "DELETE FROM Users WHERE id = :userId";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

} 

