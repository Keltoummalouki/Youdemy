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

    public function addCourse($title, $description, $content, $category_id, $user_id, $tags) {
        try {
            $this->connexion->beginTransaction();
        
            $query = "INSERT INTO COURSES (title, `description`, content, category_id, user_id) 
                     VALUES (:title, :description, :content, :category_id, :user_id)";
        
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':user_id', $user_id);
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
            error_log("Course added successfully with ID: " . $course_id);
            return $course_id;
        
        } catch (PDOException $e) {
            $this->connexion->rollBack();
            error_log("Database error: " . $e->getMessage());
            return false;
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
                `description` = :description,
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

    public function getStatistics() {
        $statistics = [];
    
        $stmt = $this->connexion->prepare("SELECT COUNT(*) FROM COURSES");
        $stmt->execute();
        $statistics['total_courses'] = $stmt->fetchColumn();
    
        $stmt = $this->connexion->prepare("
            SELECT cat.category, COUNT(c.id) as count
            FROM COURSES c
            JOIN CATEGORY cat ON c.category_id = cat.id
            GROUP BY cat.category
        ");
        $stmt->execute();
        $statistics['courses_by_category'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmt = $this->connexion->prepare("
            SELECT c.title, COUNT(ce.user_id) as enrollments
            FROM CourseEnrollments ce
            JOIN COURSES c ON ce.course_id = c.id
            GROUP BY ce.course_id
            ORDER BY enrollments DESC
            LIMIT 1
        ");
        $stmt->execute();
        $statistics['most_popular_course'] = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $stmt = $this->connexion->prepare("
            SELECT u.username, COUNT(c.id) as courses_taught
            FROM COURSES c
            JOIN USERS u ON c.user_id = u.id
            WHERE u.role = 'Teacher'
            GROUP BY u.id
            ORDER BY courses_taught DESC
            LIMIT 3
        ");
        $stmt->execute();
        $statistics['top_teachers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $statistics;
    }

    public function getPaginatedCourses($page = 1, $perPage = 3) {
        $offset = ($page - 1) * $perPage;
    
        $query = "
            SELECT 
                c.id, 
                c.title, 
                c.description, 
                c.content AS contenu, 
                c.category_id AS category_id,
                cat.category AS category_name,
                c.user_id AS teacher,
                u.username,
                GROUP_CONCAT(t.tag SEPARATOR ', ') AS tags
            FROM 
                COURSES c
            LEFT JOIN 
                CATEGORY cat ON cat.id = c.category_id
            LEFT JOIN 
                USERS u ON u.id = c.user_id
            LEFT JOIN 
                CourseTag ct ON c.id = ct.course_id
            LEFT JOIN 
                TAGS t ON ct.tag_id = t.id
            GROUP BY 
                c.id, c.title, c.description, c.content, c.category_id, cat.category, c.user_id, u.username
            ORDER BY 
                c.title
            LIMIT :limit OFFSET :offset
        ";
    
        $stmt = $this->connexion->prepare($query);
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      
    public function enrollStudent($student_id, $course_id) {
        try {
            $query = "INSERT INTO Enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':course_id', $course_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getTotalCourses() {
        $query = "SELECT COUNT(*) as total FROM COURSES";
        $stmt = $this->connexion->query($query);
        return $stmt->fetchColumn();
    }


    public function getEnrolledCourses($student_id) {
        try {
            $query = "SELECT c.*, cat.category as category_name, u.username as teacher_name
                      FROM COURSES c
                      JOIN CourseEnrollments e ON c.id = e.course_id
                      LEFT JOIN CATEGORY cat ON c.category_id = cat.id
                      LEFT JOIN USERS u ON c.user_id = u.id
                      WHERE e.user_id = :user_id";
            
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':user_id', $student_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
        
}