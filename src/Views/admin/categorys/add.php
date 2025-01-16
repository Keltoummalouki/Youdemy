<?php 

require_once '../../../../vendor/autoload.php';
         
use App\Controllers\CategoryController;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST["category"])) {
    } else {
        $category = $_POST["category"];
        if ($category === "") {
            header("Location: ../categorys/add.php");
        } else {
            $CategoryController = new CategoryController();
            $CategoryController->createCategory($category);
        }
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
        <form method="POST" action="" aling="center">
            <h1>Add Category</h1>
            <div class="input-box">
                <input type="text" placeholder="Name" name="category" require>
                <box-icon type='solid' name='user-circle'></box-icon>
            </div>

            <button type="submit" class="btn" name="submit-btn">Add</button>

            </div>
        </form>
    </div>
</body>
</html>