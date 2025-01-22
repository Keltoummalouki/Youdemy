<?php
require_once '../../../vendor/autoload.php';

use App\Models\CourseModel;
use App\Models\VideoModel;

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$courseModel = new CourseModel();

$courses = $courseModel->getEnrolledCourses($student_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="../../../assets/styles/catalog.css">
</head>
<body>
    <header>
        <div class="logosec">
            <div class="logo">You<span>demy</span></div>
        </div>
        <div class="message">
            <div class="dp">
                <img src="../../../assets/media/image/Profil.png" class="dpicn" alt="Photo de profil">
            </div>
        </div>
    </header>

    <main class="main-content">
        <a href="./index.php" class="return-link">
            <img src="../../../assets/media/image/fleche-gauche.png" alt="Retour" class="return-icon">
        </a>
        <h1>My Courses</h1>
        
        <div class="courses-grid">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <article class="course-card">
                    <div class="course-content">
                            <?php
                            $videoId = VideoModel::getYoutubeVideoId($course['content']);
                            ?>
                            
                            <?php if ($videoId): ?>
                                <div class="video-container">
                                    <iframe 
                                        src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            <?php else: ?>
                                <button class="document-button" onclick="window.open('<?php echo htmlspecialchars($course['content']); ?>', '_blank')">
                                    View Course Content
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="course-info">
                            <h3 class="course-title">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </h3>
                            <p class="course-instructor">
                                Instructor: <?php echo htmlspecialchars($course['teacher_name']); ?>
                            </p>
                            <p class="course-description">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                        </div>

                        <div class="course-tags">
                            <?php if (isset($course['category_name'])): ?>
                                <button class="category-btn">
                                    <?php echo htmlspecialchars($course['category_name']); ?>
                                </button>
                            <?php endif; ?>
                            <?php if (!empty($course['tags'])): ?>
                                <?php foreach (explode(', ', $course['tags']) as $tag): ?>
                                    <button class="tag-btn">
                                        <?php echo htmlspecialchars($tag); ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-content">No courses found. Enroll in some courses to see them here!</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>