<?php

require_once '../../../vendor/autoload.php';
use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();

function getStatistics($conn) {
    $statistics = [];

    $statistics['courses_by_category'] = $conn->query("
        SELECT cat.category, COUNT(c.id) as count
        FROM COURSES c
        JOIN CATEGORY cat ON c.category_id = cat.id
        GROUP BY cat.category
    ")->fetchAll(PDO::FETCH_ASSOC);

    $statistics['most_popular_course'] = $conn->query("
        SELECT c.title, COUNT(ce.user_id) as enrollments
        FROM CourseEnrollments ce
        JOIN COURSES c ON ce.course_id = c.id
        GROUP BY ce.course_id
        ORDER BY enrollments DESC
        LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    $statistics['top_teachers'] = $conn->query("
        SELECT u.username, COUNT(c.id) as courses_taught
        FROM COURSES c
        JOIN USERS u ON c.user_id = u.id
        WHERE u.role = 'Teacher'
        GROUP BY u.id
        ORDER BY courses_taught DESC
        LIMIT 3
    ")->fetchAll(PDO::FETCH_ASSOC);

    return $statistics;
}

$statistics = getStatistics($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques de la Plateforme</title>
    <link rel="stylesheet" href="../../../assets/styles/statistic.css">
</head>
<body>
    <a href="./dashboard.php"><img src="../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <h1>Statistiques de la Plateforme</h1>

    <div class="statistics-container">

        <div class="statistic">
            <h2>Répartition des cours par catégorie</h2>
            <ul>
                <?php if (!empty($statistics['courses_by_category'])): ?>
                    <?php foreach ($statistics['courses_by_category'] as $category): ?>
                        <li><?= htmlspecialchars($category['category']) ?>: <?= $category['count'] ?> cours</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucune catégorie trouvée.</li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="statistic">
            <h2>Cours le plus populaire</h2>
            <p>
                <?= htmlspecialchars($statistics['most_popular_course']['title'] ?? 'N/A') ?>
                (<?= $statistics['most_popular_course']['enrollments'] ?? '0' ?> inscriptions)
            </p>
        </div>

        <div class="statistic">
            <h2>Top 3 enseignants</h2>
            <ul>
                <?php if (!empty($statistics['top_teachers'])): ?>
                    <?php foreach ($statistics['top_teachers'] as $teacher): ?>
                        <li><?= htmlspecialchars($teacher['username']) ?>: <?= $teacher['courses_taught'] ?> cours</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucun enseignant trouvé.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>