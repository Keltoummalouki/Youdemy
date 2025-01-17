<?php 
require_once '../../../../vendor/autoload.php';
         
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
        echo "Invalid course ID.";
        exit(); 
    }

    $result = $courseController->deleteCourse($courseId);

    if ($result) {
        header("Location: ../dashboard.php");
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
    <link rel="stylesheet" href="../../../../assets/styles/addform.css">
    <title>Delete Course</title>
    <style>
        .error-message {
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff0000;
            color: #ff0000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .confirmation-box {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .course-details {
            margin: 15px 0;
        }

        .course-details p {
            margin: 10px 0;
            color: #fff;
        }

        .warning {
            color: #ff0000;
            font-style: italic;
            margin-top: 15px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-danger {
            background-color: #ff0000;
        }

        .btn-secondary {
            background-color: #666;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            padding: 12px 0;
            width: 100%;
            border-radius: 40px;
            color: white;
            font-weight: 600;
        }

        .btn-danger:hover {
            background-color: #cc0000;
        }

        .btn-secondary:hover {
            background-color: #555;
        }
    </style>
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