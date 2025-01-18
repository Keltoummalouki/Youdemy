<?php
require_once '../../../vendor/autoload.php';

use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();

$categorys = $conn->query("SELECT * FROM CATEGORY ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;

try {
    $stmt = $conn->prepare("
        SELECT 
            c.id, 
            c.title, 
            c.description, 
            c.content AS contenu, 
            c.category_id AS category_id,
            cat.category AS category_name,  -- Ajout du nom de la catégorie
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
    ");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <img src="../../../assets/media/image/Profil.png" class="dpicn" alt="Photo de profil">
                <a href="../../auth/login.php" aria-label="Se connecter"></a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <nav class="categories" aria-label="Catégories de cours">
            <?php if (!empty($categorys)): ?>
                <?php foreach ($categorys as $category): ?>
                    <button class="category-btn">
                        <?php echo htmlspecialchars($category['category']) ?>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-content">Aucune catégorie trouvée.</p>
            <?php endif; ?>
        </nav>

        <div class="courses-grid">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <article class="course-card">
                        <img src="../../../assets/media/image/python.png" 
                             class="course-image" 
                             alt="<?php echo htmlspecialchars($course['title']); ?>">
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
                <p class="no-content">Aucun cours trouvé.</p>
            <?php endif; ?>
        </div>

        <nav class="pagination" aria-label="Navigation des pages">
            <?php if ($page > 1): ?>
                <button class="pagination-btn" aria-label="Page précédente" onclick="window.location.href='?page=<?= $page - 1 ?>'">«</button>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>" onclick="window.location.href='?page=<?= $i ?>'"><?= $i ?></button>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <button class="pagination-btn" aria-label="Page suivante" onclick="window.location.href='?page=<?= $page + 1 ?>'">»</button>
            <?php endif; ?>
        </nav>
    </main>
</body>
</html>