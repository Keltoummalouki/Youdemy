<?php 

require_once '../../../../vendor/autoload.php';
         
use App\Controllers\TagController;

$tagController = new TagController(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_id'])) {
    $tagId = $_POST['player_id'];

    if (filter_var($tagId, FILTER_VALIDATE_INT) === false) {
        echo "Invalid tag ID.";
        exit(); 
    }

    $result = $tagController->deleteTag($tagId);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting tag.";
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
    <title>Tag</title>
</head>
<body>
    <a href="./index.php"><img src="../../../../assets/media/image/fleche-gauche.png" alt="return" class="return-icon"></a>
    <div class="container">
        <form method="POST" action="" aling="center">
            <h1>Delete Tag</h1>
            
            <button type="submit" class="btn" name="submit-btn">Confirm</button>

            </div>
        </form>
    </div>
</body>
</html>