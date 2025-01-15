<?php

namespace App\Controllers;

use App\Config\DatabaseConnexion;
use App\Models\UserModel;
use App\Models\NewUserModel;
use PDO;

class AuthController {
    
    
    public function login($email, $password) {
        $userModel = new UserModel();
        $user = $userModel->findUser($email, $password);
        var_dump($user);
        if ($user !== null) {
            switch ($user->getRole()) {
                case "Admin":
                    header('Location: ../admin/dashboard.php');
                    exit();
                case "Teacher":
                    header("Location: ../teacher/index.php");
                    exit();
                case "Student":
                    header("Location: ../student/index.php");
                    exit();
            }
        } else {
            header('Location: ../auth/login.php?error=invalid_credentials');
            exit();
        }
    }

    public function register($username, $email, $password, $role) {
        $newUser = new NewUserModel();
        $result = $newUser->addUser($username, $email, $password, $role);

        if ($result) {
            switch ($role) {
                case "Teacher": 
                    header("Location: ../teacher/dashboard.php");

                case "Student":
                    header("Location: ../student/index.php");

            }
        } else {
            exit();
        }
    }
}
