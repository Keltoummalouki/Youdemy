<?php
namespace App\Models;

use App\Classes\Tag;
use App\Config\DatabaseConnexion;
use PDOException;
use PDO;

class TagModel {
    private $connexion;

    public function __construct() {
        $db = new DatabaseConnexion();
        $this->connexion = $db->connect();
    }

    public function addTag($tag) {
        try {
            $query = "INSERT INTO TAGS (tag)
                     VALUES (:tag);";
    
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':tag', $tag);
            $stmt->execute();
    
            return $this->connexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null; 
        }
    }

    
    public function removeTag($tagId) {
    
        $sql = "DELETE FROM TAGS WHERE id = :tagId";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
        
    public function getTagById($tagId) {
        try {
            $query = "SELECT * FROM TAGS WHERE id = :id";
            $stmt = $this->connexion->prepare($query); 
            $stmt->bindParam(':id', $tagId, PDO::PARAM_INT);
            $stmt->execute();
            $tag = $stmt->fetch(PDO::FETCH_ASSOC); 
    
            return $tag;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null; 
        }
    }
    
        public function editTag($tagId, $newTag) {
        
            $sql = "UPDATE TAGS SET tag = :newTag WHERE id = :tagId";
            $stmt = $this->connexion->prepare($sql);
            $stmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);
            $stmt->bindParam(':newTag', $newTag, PDO::PARAM_STR); 
        
            return $stmt->execute();
    
            
        }

    
    }
    

