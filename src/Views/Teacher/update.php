<?php 
require_once '../../../vendor/autoload.php';

use App\Controllers\CourseController;
use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();

$categories = $conn->query("SELECT id, category FROM CATEGORY")->fetchAll(PDO::FETCH_ASSOC);
$tags = $conn->query("SELECT id, tag FROM TAGS")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST["courseId"] ?? null;
    $title = trim($_POST["title"] ?? '');
    $description = strip_tags(trim($_POST["description"] ?? ''));
    $description = strip_tags(trim($_POST["description"])); 
    $content = trim($_POST["content"] ?? '');
    $category_id = $_POST["category_id"] ?? null;
    $tags = $_POST["tags"] ?? [];

    $file_path = $course['file_path'] ?? null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $file_name = basename($_FILES['file']['name']);
        $file_path = $uploadDir . $file_name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            $file_path = 'uploads/' . $file_name;
        } else {
            $error = "Erreur lors du téléchargement du fichier.";
        }
    }

    $courseController = new CourseController();
    $result = $courseController->updateCourse($courseId, $title, $description, $content, $category_id, $tags, $file_path);

    if ($result) {
        header('Location: ./dashboard.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $courseId = $_GET['id'];
    
    $courseController = new CourseController();
    $course = $courseController->getCourseById($courseId);

    if (!$course) {
        echo "Course not found.";
        exit();
    }

    $currentTags = $conn->query("SELECT tag_id FROM CourseTag WHERE course_id = " . $courseId)->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="../../../assets/styles/addform.css">
    <title>Edit Course</title>
</head>
<body>
    <a href="./dashboard.php"><img src="../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">
    <form method="POST" action="" id="form-edit" enctype="multipart/form-data">
        <h1>Edit Course</h1>
        <input type="hidden" name="courseId" value="<?= htmlspecialchars($courseId) ?>">
        
        <div class="input-box">
            <input type="text" 
                placeholder="Title" 
                name="title" 
                value="<?= htmlspecialchars($course['title'] ?? '') ?>" 
                required>
        </div>

        <div class="input-box">
            <input type="text" 
                placeholder="Content" 
                name="content" 
                value="<?= htmlspecialchars($course['content'] ?? '') ?>" 
                required>
        </div>

        <div class="input-box">
            <div id="editor-container">
                <div id="editor"><?= htmlspecialchars($course['description'] ?? '') ?></div>
            </div>
            <input type="hidden" name="description" id="description-input">
        </div>

        <div class="input-box">
            <select name="category_id" class="input-select" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>"
                            <?= ($course['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input-box">
            <div class="tags-container">
                <?php foreach ($tags as $tag): ?>
                    <label class="tag-checkbox">
                        <input type="checkbox" 
                            name="tags[]" 
                            value="<?= htmlspecialchars($tag['id']) ?>"
                            <?= in_array($tag['id'], $currentTags ?? []) ? 'checked' : '' ?>>
                        <span class="tag-label"><?= htmlspecialchars($tag['tag']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="input-box">
            <input type="file" name="file" accept="video/*,image/*,application/pdf">
        </div>

        <button type="submit" class="btn" name="submit-btn">Update Course</button>
    </form>
    </div>

    <script src="../../../assets/js/form.js"></script>
</body>
</html>