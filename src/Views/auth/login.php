<?php 

require_once '../../../vendor/autoload.php';

    use App\Controllers\AuthController;

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST["email"]) || empty($_POST["password"])) {
            header('Location: ./auth/login.php');
        } else {

            $email = $_POST["email"];
            $password = $_POST["password"];
            $authController = new AuthController();
            $authController->login($email, $password);
            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Email" name="email" required>
                <box-icon type='solid' name='user-circle'></box-icon>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required autocomplete="off">
                <box-icon name='lock-alt' type='solid'></box-icon>
            </div>
            <div class="remember-me">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forget password?</a>
            </div>

            <button type="submit" class="btn" name="submit-btn">Login</button>

            <div class="register-link">
                <p>
                    Don't have an account? 
                    <a href="./register.php">Register</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>