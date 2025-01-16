<?php
namespace App\Models;

use App\Classes\Category;
use App\Config\DatabaseConnexion;
use PDOException;
use PDO;

class CategoryModel {
    private $connexion;

    public function __construct() {
        $db = new DatabaseConnexion();
        $this->connexion = $db->connect();
    }

    public function addCategory($category) {
        try {

            $query = "INSERT INTO CATEGORY (category)
                        VALUES (:category);";

            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':category', $category);
            $stmt->execute();

            return $this->connexion->lastInsertId();
        } catch (PDOException $e) {
            return null; 
        }
    }

    
    public function removeCategory($categoryId) {
    
        $sql = "DELETE FROM CATEGORY WHERE id = :categoryId";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
        
    public function getCategoryById($categoryId) {
        try {
            $query = "SELECT * FROM CATEGORY WHERE id = :id";
            $stmt = $this->connexion->prepare($query); 
            $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC); 
    
            return $category;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null; 
        }
    }
    
    public function editCategory($categoryId, $newCategory) {
        try {
            $sql = "UPDATE CATEGORY SET category = :newCategory WHERE id = :categoryId";
            $stmt = $this->connexion->prepare($sql);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':newCategory', $newCategory, PDO::PARAM_STR); 
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false; 
        }
    }

    
    }
    

