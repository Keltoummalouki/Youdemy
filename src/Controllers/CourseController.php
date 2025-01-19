<?php

namespace App\Controllers;

use App\Classes\Course;
use App\Models\CourseModel;
use App\Services\SessionManager;

class CourseController {
    
    public function createCourse($title, $description, $content, $category_id, $user_id, $tags, $file_path = null) {
        SessionManager::requireAuth();
        SessionManager::checkRole(['Teacher', 'Admin']);
        try {
            $newCourse = new CourseModel();
            $course_id = $newCourse->addCourse($title, $description, $content, $category_id, $user_id, $tags, $file_path);
            
            if ($course_id) {
              
                header("Location: ./dashboard.php");
                exit();
            } else {
                header("Location: ../courses/add.php?error=creation_failed");
                exit();
            }
        } catch (\Exception $e) {
            error_log("Error in createCourse: " . $e->getMessage());
            header("Location: ../courses/add.php?error=database_error");
            exit();
        }
    }

    public function deleteCourse($courseId) {

        $deleteCourse = new CourseModel(); 

        $result = $deleteCourse->removeCourse($courseId);

        return $result;
    }

    public function updateCourse($courseId, $title, $description, $content, $category_id, $tags, $file_path = null) {
        $updateCourse = new CourseModel();
        $result = $updateCourse->editCourse($courseId, $title, $description, $content, $category_id, $tags, $file_path);
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
      
    public function enrollStudent($student_id, $course_id) {
        $courseModel = new CourseModel();
        return $courseModel->enrollStudent($student_id, $course_id);
    }


        require_once '../Views/student/index.php';
    }


}