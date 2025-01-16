<?php 

require_once '../../../../vendor/autoload.php';

use App\Controllers\TagController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tag = trim($_POST["tag"] ?? '');
    $tagId = $_POST["tagId"] ?? null;

    $tagController = new TagController();
    $result = $tagController->updateTag((int)$tagId, $tag);

    header("Location: ./index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $tagId = $_GET['id'];
    
    $tagController = new TagController();
    $tag = $tagController->getTagById($tagId);

    if (!$tag) {
        echo "Tag not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../../assets/styles/addform.css">
    <title>Tag</title>
</head>
<body>
    <a href="./index.php"><img src="../../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">
        <form method="POST" action="">
            <h1>Edit Tag</h1>
            <input type="hidden" name="tagId" value="<?= htmlspecialchars($tagId) ?>">
            <div class="input-box">
                <input type="text" placeholder="Name" name="tag" value="<?= htmlspecialchars($tag['tag'] ?? '') ?>" required>
                <box-icon type='solid' name='user-circle'></box-icon>
            </div>

            <button type="submit" class="btn" name="submit-btn">Update</button>
        </form>
    </div>
</body>
</html>