<?php

require_once '../../../../vendor/autoload.php';

use App\Controllers\CourseController;
use App\Config\DatabaseConnexion;

$db = new DatabaseConnexion();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["title"], $_POST["content"], $_POST["description"], $_POST["course_id"], $_POST["tags"])) {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $description = $_POST["description"];
        $category_id = $_POST["course_id"]; 
        $user_id = $_SESSION['user_id'];
        $tags = $_POST["tags"]; 

        $courseController = new CourseController();
        $courseController->createCourse($title, $description, $content, $category_id, $user_id, $tags);

        header('Location: ;./dashboard.php');
        exit;
    } else {
        header("Location: ../courses/add.php?error=missing_fields"); 
    }
}

$categorys = $conn->query("SELECT category FROM CATEGORY")->fetchAll(PDO::FETCH_ASSOC);
$tags = $conn->query("SELECT tag FROM TAGS")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="../../../../assets/styles/addform.css">
    <title>Course</title>
</head>
<body>
<a href="../dashboard.php"><img src="../../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">
        <form method="POST" action="" align="center" id="form-add">
        <h1>Add Course</h1>
        <div class="input-box">
            <input type="text" placeholder="title" name="title" required>
            <box-icon type='solid' name='user-circle'></box-icon>
        </div>
        <div class="input-box">
            <input type="text" placeholder="content" name="content" required>
            <box-icon type='solid' name='user-circle'></box-icon>
        </div>

        <div class="input-box">
        <div id="editor-container">
                <div id="editor"></div>
            </div>
            <input type="hidden" name="description" id="description-input">
            <box-icon type='solid' name='user-circle'></box-icon>
        </div>


        <div class="input-box">
            <select name="course_id" class="input-select" id="course_id" required>
            <?php
            foreach ($categorys as $category) {
                echo "<option value=\"" . $category[''] . "\">" . $category['category'] . "</option>";
                }
            ?>
        </select><br>
        </div>
        <div class="input-box">
            <div class="tags-container">
                        <?php
                        foreach ($tags as $tag) {
                            echo "<label class='tag-checkbox'>
                                    <input type='checkbox' name='tags[]' value='" . $tag['tag'] . "'>
                                    <span class='tag-label'>" . $tag['tag'] . "</span>
                                </label>";
                        }
                        ?>
                </div>
            </div>
            <button type="submit" class="btn" name="submit-btn">Add</button>
        </div>
        </form>
    </div>
    <script src="../../../../assets/js/form.js"></script>
</body>
</html>

