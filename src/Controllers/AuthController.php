<?php

namespace App\Controllers;

use App\Classes\User;
use App\Config\DatabaseConnexion;
use App\Models\NewUserModel;
use PDO;

class AuthController {
    

    public function register($username, $email, $password, $role) {
        $newUser = new NewUserModel();
        $result = $newUser->addUser($username, $email, $password, $role);

        if ($result) {
            switch ($role) {
                case "Teacher": 
                    header("Location: ../teacher/index.php");
                    exit();
                case "Student":
                    header("Location: ../student/index.php");
                    exit();
            }
        } else {
            header('Location: ../auth/register.php?error=registration_failed');
            exit();
        }
    }
}
