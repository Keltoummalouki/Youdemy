<?php
require_once '../../../vendor/autoload.php';

use App\Controllers\EnrollmentController;
use App\Services\SessionManager;

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$enrollmentController = new EnrollmentController();
$course = null;
$error = null;

if (isset($_GET['course_id'])) {
    $courseId = filter_var($_GET['course_id'], FILTER_VALIDATE_INT);
    if ($courseId === false) {
        $error = "Invalid course ID.";
    } else {
        $course = $enrollmentController->getCourseDetails($courseId);
        if (!$course) {
            $error = "Course not found.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['course_id'])) {
        $error = "Missing required information.";
    } else {
        $courseId = filter_var($_POST['course_id'], FILTER_VALIDATE_INT);
        $userId = $_SESSION['user_id'];
        
        if ($courseId === false) {
            $error = "Invalid course ID.";
        } else {
            if ($enrollmentController->isEnrolled($userId, $courseId)) {
                $error = "You are already enrolled in this course.";
            } else {
                $result = $enrollmentController->enrollCourse($userId, $courseId);
                
                if ($result) {
                    header("Location: ./index.php?success=enrolled");
                    exit();
                } else {
                    $error = "Enrollment failed. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../assets/styles/addform.css">
    <title>Enroll Course</title>
</head>
<body>
    <a href="../dashboard.php">
        <img src="../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon">
    </a>
    
    <div class="container">
    <?php if (isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($course): ?>
        <form method="POST" action="">
            <h1>Enroll in Course</h1>
            <div class="course-details">
                <h2><?= htmlspecialchars($course['title']) ?></h2>
                <?php if (isset($course['instructor'])): ?>
                    <p>Instructor: <?= htmlspecialchars($course['instructor']) ?></p>
                <?php endif; ?>
                <?php if (isset($course['description'])): ?>
                    <p><?= htmlspecialchars($course['description']) ?></p>
                <?php endif; ?>
            </div>
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($courseId) ?>">
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary" name="submit-btn">Confirm Enrollment</button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>