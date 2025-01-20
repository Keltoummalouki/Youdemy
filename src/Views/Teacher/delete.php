<?php 
require_once '../../../vendor/autoload.php';
         
use App\Controllers\CourseController;

$courseController = new CourseController(); 

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $courseId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if ($courseId === false) {
        echo "Invalid course ID.";
        exit();
    }

    $course = $courseController->getCourseById($courseId);
    
    if (!$course) {
        echo "Course not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $courseId = filter_var($_POST['course_id'], FILTER_VALIDATE_INT);
    if ($courseId === false) {
        $error = "Invalid course ID.";
        exit();
    }

    $result = $courseController->deleteCourse($courseId);
    if ($result) {
        header("Location: ./dashboard.php");
        exit();
    } else {
        $error = "Error deleting course.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../assets/styles/deleteCourse.css">
    <title>Delete Course</title>
</head>
<body>
    <a href="../dashboard.php"><img src="../../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <h1>Delete Course</h1>
            
            <div class="confirmation-box">
                <p>Are you sure you want to delete this course?</p>
                <div class="course-details">
                    <p><strong>Title:</strong> <?= htmlspecialchars($course['title'] ?? '') ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars($course['category_name'] ?? '') ?></p>
                    <?php if (!empty($course['tags'])): ?>
                        <p><strong>Tags:</strong> <?= htmlspecialchars($course['tags']) ?></p>
                    <?php endif; ?>
                </div>
                <p class="warning">This action cannot be undone.</p>
            </div>

            <input type="hidden" name="course_id" value="<?= htmlspecialchars($courseId) ?>">
            
            <div class="button-group">
                <button type="submit" class="btn btn-danger" name="submit-btn">Confirm Delete</button>
                <a href="../dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>