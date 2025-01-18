<?php

namespace App\Models;

use App\Config\DatabaseConnexion;
use PDO;
use PDOException;

class CourseEnrollment {
    private $connexion;

    public function __construct() {
        $db = new DatabaseConnexion();
        $this->connexion = $db->connect();
    }
    
    public function enrollStudentInCourse($userId, $courseId) {
        try {
            $query = "INSERT INTO CourseEnrollments (user_id, course_id) 
                     VALUES (:user_id, :course_id)";
            
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return false;
            }
            throw $e;
        }
    }

    public function getCourseDetails($courseId) {
        $query = "SELECT c.*, u.username as instructor_name 
                 FROM COURSES c 
                 LEFT JOIN USERS u ON c.user_id = u.id 
                 WHERE c.id = :course_id";
        
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add this method to check if a user is enrolled
    public function isEnrolled($userId, $courseId) {
        $query = "SELECT COUNT(*) FROM CourseEnrollments 
                 WHERE user_id = :user_id AND course_id = :course_id";
        
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
}