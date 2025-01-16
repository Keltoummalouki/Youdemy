<?php 

require_once '../../../../vendor/autoload.php';
         
use App\Controllers\AuthController;

$categoryController = new UserController(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_id'])) {
    $categoryId = $_POST['player_id'];

    if (filter_var($categoryId, FILTER_VALIDATE_INT) === false) {
        echo "Invalid category ID.";
        exit(); 
    }

    $result = $categoryController->deleteCategory($categoryId);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting category.";
    }
} else {
    echo "Invalid request.";
}
?>


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
        <form method="POST" action="" aling="center">
            <h1>Delete User</h1>
            
            <button type="submit" class="btn" name="submit-btn">Confirm</button>

            </div>
        </form>
    </div>
</body>
</html>