<?php

session_start();


require_once '../../../vendor/autoload.php';

use App\Controllers\CourseController;
use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["title"], $_POST["content"], $_POST["description"], $_POST["course_id"])) {
        $title = trim($_POST["title"]);
        $content = trim($_POST["content"]);
        $description = trim($_POST["description"]);
        $category_id = $_POST["course_id"]; 
        $user_id = $_SESSION['user_id'];
        $tags = isset($_POST["tags"]) ? $_POST["tags"] : []; 

        $courseController = new CourseController();
        try {
            $courseController->createCourse($title, $description, $content, $category_id, $user_id, $tags);
            header('Location: ./dashboard.php');
            exit();
        } catch (\Exception $e) {
            $error = "Erreur lors de la création du cours: " . $e->getMessage();
        }
    } else {
        header("Location: ./add.php?error=missing_fields"); 
        exit();
    }
}

$categorys = $conn->query("SELECT id, category FROM CATEGORY")->fetchAll(PDO::FETCH_ASSOC);
$tags = $conn->query("SELECT id, tag FROM TAGS")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="../../../assets/styles/addform.css">
    <title>Add Course</title>
</head>
<body>
    <a href="./dashboard.php"><img src="../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">

        <form method="POST" action="" align="center" id="form-add">
            <h1>Add Course</h1>
            <div class="input-box">
                <input type="text" placeholder="Title" name="title" required>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Content" name="content" required>
            </div>

            <div class="input-box">
                <div id="editor-container">
                    <div id="editor"></div>
                </div>
                <input type="hidden" name="description" id="description-input">
            </div>

            <div class="input-box">
                <select name="course_id" class="input-select" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categorys as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-box">
                <div class="tags-container">
                    <?php foreach ($tags as $tag): ?>
                        <label class='tag-checkbox'>
                            <input type='checkbox' name='tags[]' value='<?php echo htmlspecialchars($tag['id']); ?>'>
                            <span class='tag-label'><?php echo htmlspecialchars($tag['tag']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" class="btn" name="submit-btn">Add</button>
        </form>
    </div>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                ]
            }
        });

        document.getElementById('form-add').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer le contenu de l'éditeur
            var description = document.getElementById('description-input');
            description.value = quill.root.innerHTML;
            
            // Soumettre le formulaire
            this.submit();
        });
    </script>
</body>
</html>