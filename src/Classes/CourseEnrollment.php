<?php 

namespace App\Classes;

    class CourseEnrollment {
        private $connexion;
    
        public function __construct($db = null) {
            if ($db === null) {
                $db = new DatabaseConnexion();
            }
            $this->connexion = $db->connect();
        }
    
    public function enrollCourse($userId, $courseId) {
        return $this->courseEnrollment->enrollStudentInCourse($userId, $courseId);
    }
    
    public function getCourseDetails($courseId) {
        return $this->courseEnrollment->getCourseDetails($courseId);
    }
}