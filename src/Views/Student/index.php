<?php
require_once '../../../vendor/autoload.php';

use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();

$categorys = $conn->query("SELECT * FROM CATEGORY ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);
$result = false;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 3;
$offset = ($page - 1) * $perPage;

try {
    $stmt = $conn->prepare("
        SELECT 
            c.id, 
            c.title, 
            c.description, 
            c.content AS contenu, 
            c.category_id AS category_id,
            cat.category AS category_name,
            c.user_id AS teacher,
            u.username,
            GROUP_CONCAT(t.tag SEPARATOR ', ') AS tags
        FROM 
            COURSES c
        LEFT JOIN 
            CATEGORY cat ON cat.id = c.category_id
        LEFT JOIN 
            USERS u ON u.id = c.user_id
        LEFT JOIN 
            CourseTag ct ON c.id = ct.course_id
        LEFT JOIN 
            TAGS t ON ct.tag_id = t.id
        GROUP BY 
            c.id, c.title, c.description, c.content, c.category_id, cat.category, c.user_id, u.username
        ORDER BY 
            c.title
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCourses = $conn->query("SELECT COUNT(*) FROM COURSES")->fetchColumn();
    $totalPages = ceil($totalCourses / $perPage);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $courses = [];
}

if (isset($_POST['enroll'])) {
    $student_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $result = $courseModel->enrollStudent($student_id, $course_id); 
}

if ($result) {
    header("Location: ./my_courses.php?success=enrolled");
    exit();
} else {
    $error = "Enrollment failed. Please try again.";
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

try {
    $sql = "
        SELECT 
            c.id, 
            c.title, 
            c.description, 
            c.content AS contenu, 
            c.category_id AS category_id,
            cat.category AS category_name,
            c.user_id AS teacher,
            u.username,
            GROUP_CONCAT(t.tag SEPARATOR ', ') AS tags
        FROM 
            COURSES c
        LEFT JOIN 
            CATEGORY cat ON cat.id = c.category_id
        LEFT JOIN 
            USERS u ON u.id = c.user_id
        LEFT JOIN 
            CourseTag ct ON c.id = ct.course_id
        LEFT JOIN 
            TAGS t ON ct.tag_id = t.id
        WHERE 
            (:search = '' OR c.title LIKE :search OR t.tag LIKE :search OR u.username LIKE :search)
            AND (:category = 0 OR c.category_id = :category)
        GROUP BY 
            c.id, c.title, c.description, c.content, c.category_id, cat.category, c.user_id, u.username
        ORDER BY 
            c.title
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCoursesQuery = "
        SELECT COUNT(DISTINCT c.id)
        FROM COURSES c
        LEFT JOIN CourseTag ct ON c.id = ct.course_id
        LEFT JOIN TAGS t ON ct.tag_id = t.id
        WHERE 
            (:search = '' OR c.title LIKE :search OR t.tag LIKE :search)
            AND (:category = 0 OR c.category_id = :category)
    ";
    $totalStmt = $conn->prepare($totalCoursesQuery);
    $totalStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $totalStmt->bindValue(':category', $category, PDO::PARAM_INT);
    $totalStmt->execute();
    $totalCourses = $totalStmt->fetchColumn();
    $totalPages = ceil($totalCourses / $perPage);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $courses = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Catalogue des cours Youdemy - Plateforme d'apprentissage en ligne">
    <link rel="stylesheet" href="../../../assets/styles/catalog.css">
    <title>Courses Catalog</title>
</head>
<body>
    <header>
        <div class="logosec">
            <div class="logo">You<span>demy</span></div>
        </div>

        <div class="searchbar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Rechercher un cours ou un enseignant" aria-label="Rechercher" value="<?php echo htmlspecialchars($search); ?>">
                <button class="searchbtn">
                    <img src="../../../assets/media/image/search.png" class="icn srchicn" alt="Icône de recherche">
                </button>
            </form>
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
                        <a href="#">Dashboard</a>
                    </div>

                    <div class="nav-option option2">
                        <img src="../../../assets/media/image/teacherblack.png"
                            class="nav-img"
                            alt="institution">
                        <a href="./mycourse.php"> My Course</a>
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
        <nav class="categories" aria-label="Catégories de cours">
            <button class="category-btn">
                <a href="?category=0&search=<?= urlencode($search) ?>">All Category</a>
            </button>
            <?php if (!empty($categorys)): ?>
                <?php foreach ($categorys as $cat): ?>
                    <button class="category-btn">
                        <a href="?category=<?php echo htmlspecialchars($cat['id']); ?>&search=<?= urlencode($search) ?>">
                            <?php echo htmlspecialchars($cat['category']); ?>
                        </a>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-content">No Category found</p>
            <?php endif; ?>
        </nav>
        </nav>

            <div class="courses-grid">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <article class="course-card">
                            <div class="course-info">
                                <h3 class="course-title">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </h3>
                                <p class="course-instructor">
                                    <?php echo htmlspecialchars($course['username']); ?>
                                </p>
                                <div class="course-rating">
                                    <span class="rating-stars" aria-label="Note de 4.8 sur 5">★★★★★</span>
                                    <span>4.8 (2,345 avis)</span>
                                </div>
                                <button class="enroll-btn"> 
                                    <a href="./enroll.php?course_id=<?= htmlspecialchars($course['id']) ?>">Enroll</a>
                                </button>
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
                    <p class="no-content">No courses found</p>
                <?php endif; ?>
            </div>

            <nav class="pagination" aria-label="Navigation des pages">
                <?php if ($page > 1): ?>
                    <button class="pagination-btn" aria-label="Page précédente" onclick="window.location.href='?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>'">«</button>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>" onclick="window.location.href='?page=<?= $i ?>&search=<?= urlencode($search) ?>'"><?= $i ?></button>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <button class="pagination-btn" aria-label="Page suivante" onclick="window.location.href='?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>'">»</button>
                <?php endif; ?>
            </nav>
        </main>
    </div>
</body>
</html>