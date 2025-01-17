<?php 

namespace App\Controllers;

use App\Models\CourseEnrollment;
use App\Config\DatabaseConnexion;

class EnrollmentController {
    private $enrollmentModel;

    public function __construct($db = null) {
        if ($db === null) {
            $db = new DatabaseConnexion();
        }
        $this->enrollmentModel = new CourseEnrollment($db);
    }


    public function enrollCourse($userId, $courseId) {
        if (!$userId || !$courseId) {
            return false;
        }

        if ($this->enrollmentModel->isEnrolled($userId, $courseId)) {
            return false;
        }

        $courseDetails = $this->getCourseDetails($courseId);
        if (!$courseDetails || !$courseDetails['is_active']) {
            return false;
        }

        return $this->enrollmentModel->enrollStudentInCourse($userId, $courseId);
    }

    public function getCourseDetails($courseId) {
        if (!$courseId) {
            return null;
        }

        $course = $this->enrollmentModel->getCourseDetails($courseId);
        
        if (!$course) {
            return null;
        }


        return [
            'id' => $course['id'],
            'title' => $course['title'],
            'instructor' => $course['instructor_name'],
            'duration' => $course['duration'] ?? null,
            'description' => $course['description'] ?? null,
            'is_active' => $course['is_active'] ?? true
        ];
    }
}