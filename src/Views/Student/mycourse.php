<?php
require_once '../../../vendor/autoload.php';

use App\Models\CourseModel;
use App\Services\SessionManager;

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$courseModel = new CourseModel();

$enrolledCourses = $courseModel->getEnrolledCourses($student_id);


$contentLink = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";

function extractYouTubeVideoId($url) {
    $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    preg_match($pattern, $url, $matches);
    return isset($matches[1]) ? $matches[1] : null;
}

$isYouTube = strpos($contentLink, 'youtube.com') !== false || strpos($contentLink, 'youtu.be') !== false;

$videoId = $isYouTube ? extractYouTubeVideoId($contentLink) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Catalogue des cours Youdemy - Plateforme d'apprentissage en ligne">
    <link rel="stylesheet" href="../../../assets/styles/catalog.css">
    <title>Youdemy - Catalogue de Cours</title>
</head>
<body>
    <header>
        <div class="logosec">
            <div class="logo">You<span>demy</span></div>
        </div>

        <div class="searchbar">
            <input type="text" placeholder="Rechercher un cours" aria-label="Rechercher">
            <button class="searchbtn">
                <img src="../../../assets/media/image/search.png" class="icn srchicn" alt="Icône de recherche">
            </button>
        </div>

        <div class="message">
            <div class="circle"></div>
            <img src="../../../assets/media/image/notification.png" class="icn" alt="Notifications">
            <div class="dp">
                <a href="./src/Views/auth/login.php"><img src="./assets/media/image/Profil.png" class="dpicn"></a>
            </div>
        </div>
    </header>
    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option option1">
                        <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                            class="nav-img"
                            alt="dashboard">
                        <a href="./index.php">Dashboard</a>
                    </div>

                    <div class="nav-option option2">
                        <img src="../../../assets/media/image/teacherblack.png"
                            class="nav-img"
                            alt="institution">
                        <a href="#"> My Course</a>
                    </div>

                    <div class="nav-option option5">
                        <img src="../../../assets/media/image/report.png"
                            class="nav-img"
                            alt="raport">
                        <h3> Report</h3>
                    </div>

                    <div class="nav-option option6">
                        <img src="../../../assets/media/image/settings.png"
                            class="nav-img"
                            alt="settings">
                        <a href="#"> Settings</a>
                    </div>

                    <div class="nav-option logout">
                        <img src="../../../assets/media/image/login.png"
                            class="nav-img"
                            alt="logout">
                        <a href="../auth/logout.php">Logout</a>
                    </div>
                </div>
            </nav>
        </div>

        <main class="main">
            <h1>My Courses</h1>

            <div class="courses-grid">
                <?php if (!empty($enrolledCourses)): ?>
                    <?php foreach ($enrolledCourses as $course): ?>
                        <article class="course-card">
                            <div class="course-content">
                            <?php if ($isYouTube && $videoId): ?>
                                <iframe 
                                    width="560" 
                                    height="315" 
                                    src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen class="course-content" >
                                </iframe>
                            <?php else: ?>
                                <button class="document-button" onclick="window.open('<?php echo htmlspecialchars($contentLink); ?>', '_blank')" class="course-content">
                                    Show Document
                                </button>
                            <?php endif; ?>
                            </div>
                            <div class="course-info">
                                <h3 class="course-title">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </h3>
                                <p class="course-instructor">
                                    <?php echo htmlspecialchars($course['teacher_name']); ?>
                                </p>
                                <p class="course-instructor">
                                    <?php echo htmlspecialchars($course['description']); ?>
                                </p>
                                <div class="course-tags">
                                    <button class="category-btn">
                                        <?php echo htmlspecialchars($course['category_name']); ?>
                                    </button>
                                    <?php if (!empty($course['tags'])): ?>
                                        <?php foreach (explode(', ', $course['tags']) as $tag): ?>
                                            <button class="tag-btn">
                                                <?php echo htmlspecialchars($tag); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-content">No courses found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>