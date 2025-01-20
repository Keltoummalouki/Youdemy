<?php
require_once './vendor/autoload.php';

use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();

$categorys = $conn->query("SELECT * FROM CATEGORY ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);
$result = false;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 4;
$offset = ($page - 1) * $perPage;

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
            c.title LIKE :search OR cat.category LIKE :search OR t.tag LIKE :search
        GROUP BY 
            c.id, c.title, c.description, c.content, c.category_id, cat.category, c.user_id, u.username
        ORDER BY 
            c.title
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCourses = $conn->prepare("SELECT COUNT(*) FROM COURSES c LEFT JOIN CATEGORY cat ON cat.id = c.category_id LEFT JOIN CourseTag ct ON c.id = ct.course_id LEFT JOIN TAGS t ON ct.tag_id = t.id WHERE c.title LIKE :search OR cat.category LIKE :search OR t.tag LIKE :search");
    $totalCourses->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $totalCourses->execute();
    $totalCourses = $totalCourses->fetchColumn();
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
    <link rel="stylesheet" href="./assets/styles/style.css">
    <link rel="stylesheet" href="./assets/styles/catalog.css">
    <title>Youdemy</title>
</head>
<body>

<header>
        <div class="logosec">
            <div class="logo">You<span>demy</span></div>
        </div>

        <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
        </ul>


        <div class="message">
            <div class="circle"></div>
            <img src="./assets/media/image/notification.png" class="icn" alt="Notifications">
            <div class="dp">
                <a href="./src/Views/auth/login.php"><img src="./assets/media/image/Profil.png" class="dpicn"></a>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Révolutionnez votre apprentissage</h1>
            <p>Youdemy est une plateforme de cours en ligne innovante qui offre une expérience d'apprentissage personnalisée et interactive pour les étudiants et les enseignants.</p>
            <a href="#signup" class="cta-button">Commencer gratuitement</a>
        </div>
    </section>

    <main class="main">
        <h1>Catalog</h1>
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
                                <a href="./src/Views/auth/login.php">Enroll</a>
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
                <p class="no-content">Aucun cours trouvé.</p>
            <?php endif; ?>
        </div>

        <section class="pagination" aria-label="Navigation des pages">
            <?php if ($page > 1): ?>
                <button class="pagination-btn" aria-label="Page précédente" onclick="window.location.href='?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>'">«</button>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>" onclick="window.location.href='?page=<?= $i ?>&search=<?= urlencode($search) ?>'"><?= $i ?></button>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <button class="pagination-btn" aria-label="Page suivante" onclick="window.location.href='?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>'">»</button>
            <?php endif; ?>
        </section>
    </main>

    
    <section class="features">
        <div class="features-container">
            <h2>Nos fonctionnalités</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>Apprentissage personnalisé</h3>
                    <p>Un parcours adapté à votre rythme et à vos objectifs d'apprentissage.</p>
                </div>
                <div class="feature-card">
                    <h3>Experts qualifiés</h3>
                    <p>Apprenez avec des instructeurs expérimentés et passionnés.</p>
                </div>
                <div class="feature-card">
                    <h3>Contenu interactif</h3>
                    <p>Des cours enrichis avec des quiz, des projets pratiques et des discussions en direct.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>