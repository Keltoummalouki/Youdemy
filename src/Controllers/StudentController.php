<?php

namespace App\Controllers;

use App\Config\DatabaseConnexion;
use App\Models\StudentModel;
use PDO;

class StudentController {
    private $courseModel;
    
    public function __construct() {
        $this->studentModel = new StudentModel();
    }
    
    public function index() {
        $courses = $this->studentModel->getAllCourses();
        
        require_once 'views/courses/index.php';
    }
    
    public function filterByCategory() {
        if(isset($_GET['category'])) {
            $category = $_GET['category'];
            $courses = $this->studentModel->getCoursesByCategory($category);
        } else {
            $courses = $this->studentModel->getAllCourses();
        }
        
        echo json_encode($courses);
    }
    
    public function search() {
        if(isset($_GET['q'])) {
            $searchTerm = $_GET['q'];
            $courses = $this->studentModel->searchCourses($searchTerm);
            echo json_encode($courses);
        }
    }
}