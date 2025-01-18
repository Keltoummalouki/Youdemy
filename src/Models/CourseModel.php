<?php
namespace App\Models;

use App\Config\DatabaseConnexion;
use PDOException;
use PDO;

class CourseModel {
    private $connexion;

    public function __construct() {
        $db = new DatabaseConnexion();
        $this->connexion = $db->connect();
    }

    public function addCourse($title, $description, $content, $category_id, $user_id, $tags, $file_path = null) {
        try {
            $this->connexion->beginTransaction();
    
            $query = "INSERT INTO COURSES (title, description, content, category_id, user_id, file_path) 
                     VALUES (:title, :description, :content, :category_id, :user_id, :file_path)";
    
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':file_path', $file_path);
            $stmt->execute();
    
            $course_id = $this->connexion->lastInsertId();
    
            if (!empty($tags)) {
                $tagQuery = "INSERT INTO CourseTag (course_id, tag_id) VALUES (:course_id, :tag_id)";
                $tagStmt = $this->connexion->prepare($tagQuery);
                
                foreach ($tags as $tag_id) {
                    $tagStmt->bindParam(':course_id', $course_id);
                    $tagStmt->bindParam(':tag_id', $tag_id);
                    $tagStmt->execute();
                }
            }
    
            $this->connexion->commit();
            return $course_id;
    
        } catch (PDOException $e) {
            $this->connexion->rollBack();
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function removeCourse($courseId) {
        try {
            $sql = "DELETE FROM COURSES WHERE id = :courseId";
            
            $stmt = $this->connexion->prepare($sql);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
        
    public function getCourseById($courseId) {
        try {
            $query = "SELECT c.*, 
                        GROUP_CONCAT(t.tag) as tags,
                        cat.category as category_name,
                        u.username as teacher_name
                     FROM COURSES c
                     LEFT JOIN CourseTag ct ON c.id = ct.course_id
                     LEFT JOIN TAGS t ON ct.tag_id = t.id
                     LEFT JOIN CATEGORY cat ON c.category_id = cat.id
                     LEFT JOIN USERS u ON c.user_id = u.id
                     WHERE c.id = :id
                     GROUP BY c.id";

            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':id', $courseId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }
    
    public function editCourse($courseId, $title, $description, $content, $category_id, $tags) {
        try {
            $this->connexion->beginTransaction();

            $sql = "UPDATE COURSES 
                   SET title = :title, 
                       description = :description, 
                       content = :content, 
                       category_id = :category_id
                   WHERE id = :courseId";

            $stmt = $this->connexion->prepare($sql);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();

            $deleteTagsQuery = "DELETE FROM CourseTag WHERE course_id = :courseId";
            $deleteStmt = $this->connexion->prepare($deleteTagsQuery);
            $deleteStmt->bindParam(':courseId', $courseId);
            $deleteStmt->execute();

            if (!empty($tags)) {
                $tagQuery = "INSERT INTO CourseTag (course_id, tag_id) VALUES (:course_id, :tag_id)";
                $tagStmt = $this->connexion->prepare($tagQuery);
                
                foreach ($tags as $tag_id) {
                    $tagStmt->bindParam(':course_id', $courseId);
                    $tagStmt->bindParam(':tag_id', $tag_id);
                    $tagStmt->execute();
                }
            }

            $this->connexion->commit();
            return true;

        } catch (PDOException $e) {
            $this->connexion->rollBack();
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllCourses() {
        try {
            $query = "SELECT c.*, 
                        GROUP_CONCAT(t.tag) as tags,
                        cat.category as category_name,
                        u.username as teacher_name
                     FROM COURSES c
                     LEFT JOIN CourseTag ct ON c.id = ct.course_id
                     LEFT JOIN TAGS t ON ct.tag_id = t.id
                     LEFT JOIN CATEGORY cat ON c.category_id = cat.id
                     LEFT JOIN USERS u ON c.user_id = u.id
                     GROUP BY c.id";

            $stmt = $this->connexion->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getCoursesByTeacher($user_id) {
        try {
            $query = "SELECT c.*, 
                        cat.category as category_name,
                        GROUP_CONCAT(t.tag) as tags
                     FROM COURSES c
                     LEFT JOIN CATEGORY cat ON c.category_id = cat.id
                     LEFT JOIN CourseTag ct ON c.id = ct.course_id
                     LEFT JOIN TAGS t ON ct.tag_id = t.id
                     WHERE c.user_id = :user_id
                     GROUP BY c.id
                     ORDER BY c.id DESC";
                     
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
    
}