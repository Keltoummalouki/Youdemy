<?php

require_once '../../../vendor/autoload.php';

use App\Controllers\CourseController;
use App\Config\DatabaseConnexion;
use App\Services\SessionManager;

session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$db = new DatabaseConnexion();
$conn = $db->connect();

error_log('Session data: ' . print_r($_SESSION, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["title"], $_POST["content"], $_POST["description"], $_POST["course_id"])) {
        $title = trim($_POST["title"]);
        $content = trim($_POST["content"]);
        $description = isset($_POST['description']) ? strip_tags(trim($_POST['description'])) : ''; 
        $category_id = $_POST["course_id"]; 
        $user_id = $_SESSION['user_id'];
        $tags = isset($_POST["tags"]) ? $_POST["tags"] : []; 


        $courseController = new CourseController();
        try {
            $result = $courseController->createCourse($title, $description, $content, $category_id, $user_id, $tags);
            
            if ($result) {
                $_SESSION['success_message'] = "Cours créé avec succès!";
                header('Location: ./dashboard.php');
                exit();
            } else {
                throw new \Exception("Échec de la création du cours");
            }
        } catch (\Exception $e) {
            error_log('Error creating course: ' . $e->getMessage());
            $error = "Erreur lors de la création du cours: " . $e->getMessage();
        }
    } else {
        $error = "Tous les champs requis doivent être remplis";
    }
}

try {
    $categorys = $conn->query("SELECT id, category FROM CATEGORY ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);
    $tags = $conn->query("SELECT id, tag FROM TAGS ORDER BY tag")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    $error = "Erreur de base de données";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="../../../assets/styles/addform.css">
    <title>Add coures - Youdemy</title>
</head>
<body>
    <a href="./dashboard.php" class="return-link">
        <img src="../../../assets/media/image/fleche-gauche.png" alt="Retour" class="return-icon">
    </a>
    
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="form-add" class="course-form" enctype="multipart/form-data">
            <h1>Add course</h1>
            
            <div class="input-box">
                <input type="text" 
                    placeholder="Course title" 
                    name="title" 
                    required 
                    value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            </div>

            <div class="input-box">
                <input type="url" 
                    placeholder="course content" 
                    name="content" 
                    required 
                    value="<?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?>">
            </div>

            <div class="input-box">
                <div id="editor-container">
                    <div id="editor"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></div>
                </div>
                <input type="hidden" name="description" id="description-input">
            </div>

            <div class="input-box">
                <select name="course_id" class="input-select" required>
                    <option value="">select category</option>
                    <?php foreach ($categorys as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                <?php echo (isset($_POST['course_id']) && $_POST['course_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-box">
                <div class="tags-container">
                    <?php foreach ($tags as $tag): ?>
                        <label class='tag-checkbox'>
                            <input type='checkbox' 
                                name='tags[]' 
                                value='<?php echo htmlspecialchars($tag['id']); ?>'
                                <?php echo (isset($_POST['tags']) && in_array($tag['id'], $_POST['tags'])) ? 'checked' : ''; ?>>
                            <span class='tag-label'><?php echo htmlspecialchars($tag['tag']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn" name="submit-btn">add coures</button>
        </form>
    </div>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Enter course description...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        document.getElementById('form-add').onsubmit = function() {
            var description = quill.root.innerHTML;
            
            document.getElementById('description-input').value = description;
            
            return true;
        };
    </script>
</body>
</html>