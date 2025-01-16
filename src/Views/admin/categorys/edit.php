<?php 

require_once '../../../../vendor/autoload.php';

use App\Controllers\CategoryController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST["category"] ?? '');
    $categoryId = $_POST["categoryId"] ?? null;

    $CategoryController = new CategoryController();
    $result = $CategoryController->updateCategory((int)$categoryId, $category);

    header('Location: ./index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    
    $CategoryController = new CategoryController();
    $category = $CategoryController->getCategoryById($categoryId);

    if (!$category) {
        echo "Category not found.";
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
    <title>Category</title>
</head>
<body>
    <a href="./index.php"><img src="../../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">
        <form method="POST" action="">
            <h1>Edit Category</h1>
            <input type="hidden" name="categoryId" value="<?= htmlspecialchars($categoryId) ?>">
            <div class="input-box">
                <input type="text" placeholder="Name" name="category" value="<?= htmlspecialchars($category['category'] ?? '') ?>" required>
                <box-icon type='solid' name='user-circle'></box-icon>
            </div>

            <button type="submit" class="btn" name="submit-btn">Update</button>
        </form>
    </div>
</body>
</html>