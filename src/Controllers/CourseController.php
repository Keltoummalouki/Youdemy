<?php

namespace App\Controllers;

use App\Classes\Course;
use App\Models\CourseModel;
use App\Services\SessionManager;

class CourseController {
    
    public function createCourse($title, $description, $content, $category_id, $user_id, $tags) {
        SessionManager::requireAuth();
        SessionManager::checkRole(['Teacher', 'Admin']);
        try {
            $newCourse = new CourseModel();
            $course_id = $newCourse->addCourse($title, $description, $content, $category_id, $user_id, $tags);
            
            if ($course_id) {
                header("Location: ./dashboard.php");
                exit();
            } else {
                header("Location: ./add.php");
                exit();
            }
        } catch (\Exception $e) {
            error_log("Error in createCourse: " . $e->getMessage());
            header("Location: ./add.php");
            exit();
        }
    }

    public function deleteCourse($courseId) {

        $deleteCourse = new CourseModel(); 

        $result = $deleteCourse->removeCourse($courseId);

        return $result;
    }

    public function updateCourse($courseId, $title, $description, $content, $category_id, $tags) {
        $updateCourse = new CourseModel();
        $result = $updateCourse->editCourse($courseId, $title, $description, $content, $category_id, $tags);
        return $result;
    }
    
    public function getCourseById($courseId) {

        $updateCourse= new CourseModel();

        $result = $updateCourse->getCourseById($courseId);
        
        return $result;
    }

    public function catalog() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    
        $perPage = 10;
        $courseModel = new CourseModel();
    
        $courses = $courseModel->getPaginatedCourses($page, $perPage);
    
        $totalCourses = $courseModel->getTotalCourses();
        $totalPages = ceil($totalCourses / $perPage);
    }
      
    public function enrollStudent($student_id, $course_id) {
        $courseModel = new CourseModel();
        return $courseModel->enrollStudent($student_id, $course_id);
        require_once '../Views/student/index.php';

    }

    
    public function myCourses() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../auth/login.php");
            exit();
        }

        $student_id = $_SESSION['user_id'];
        $courseModel = new CourseModel();
        $enrolledCourses = $courseModel->getEnrolledCourses($student_id);

        require_once 'views/student/my_courses.php';
    }

    public function getEnrolledCourses($student_id) {
        try {
            $query = "SELECT c.*, cat.category as category_name, u.username as teacher_name
                      FROM COURSES c
                      JOIN Enrollments e ON c.id = e.course_id
                      LEFT JOIN CATEGORY cat ON c.category_id = cat.id
                      LEFT JOIN USERS u ON c.user_id = u.id
                      WHERE e.student_id = :student_id";
            
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    }

