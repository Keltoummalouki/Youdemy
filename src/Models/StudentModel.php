<?php
namespace App\Models;

use App\Classes\User;
use App\Config\DatabaseConnexion;
use PDOException;
use PDO;

class StudentModel{
    private $connexion;

    public function __construct() {
            $db = new DatabaseConnexion();
            $this->connexion = $db->connect();
    }
        
    public function getAllCourses() {
        $query = "SELECT * FROM courses";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCoursesByCategory($category) {
        $query = "SELECT * FROM courses WHERE category = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function searchCourses($searchTerm) {
        $query = "SELECT * FROM courses WHERE title LIKE ? OR instructor LIKE ?";
        $stmt = $this->db->prepare($query);
        $searchTerm = "%$searchTerm%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
    



