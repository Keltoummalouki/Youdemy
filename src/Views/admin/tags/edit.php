<?php 

require_once '../../../../vendor/autoload.php';
         
use App\Controllers\TagController;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST["tag"])) {
       $tag = "Default tag"; 
    } else {
        $tag = $_POST["tag"];
            $TagController = new TagController();
            $TagController->updateTag($tag);
            header("Location: ./index.php");
            exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $tagId = $_GET['id'];

    if (filter_var($tagId, FILTER_VALIDATE_INT) === false) {
        echo "Invalid tag ID.";
        exit(); 
    }
    
    $tagController = new TagController();
    $tag = $tagController->getTagById($tagId);

    if (!$tag) {
        echo "tag not found.";
        exit();
    }

} else {
    echo "Invalid request.";
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
        <form method="POST" action="" aling="center">
            <h1>Edit Tag</h1>
            <div class="input-box">
                <input type="text" placeholder="Name" name="Tag" require>
                <box-icon type='solid' name='user-circle'></box-icon>
            </div>

            <button type="submit" class="btn" name="submit-btn">Add</button>

            </div>
        </form>
    </div>
</body>
</html>