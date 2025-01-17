<?php

namespace App\Controllers;

use App\Config\DatabaseConnexion;
use App\Models\UserModel;
use App\Models\NewUserModel;
use App\Services\SessionManager;
use PDO;

class AuthController {
    
    
    public function login($email, $password) {
        $userModel = new UserModel();
        $user = $userModel->findUser($email, $password);
        if ($user !== null) {
            SessionManager::setUser($user->getId(), $user->getUsername(), $user->getRole());
            switch ($user->getRole()) {
                case "Admin":
                    header('Location: ../admin/dashboard.php');
                    exit();
                case "Teacher":
                    if($user->getStatus() == "Activated"){ 
                        header("Location: ../teacher/dashboard.php");
                    }else {
                        header("Location: ../auth/accountStatus.php");
                    }
                    exit();
                case "Student":
                    if($user->getStatus() == "Activated"){ 
                        header("Location: ../student/index.php");
                    }else{
                        header("Location: ../auth/accountStatus.php"); 
                    }
                    exit();
            }
        } else {
            header('Location: ../auth/login.php?error=invalid_credentials');
            exit();
        }
    }

    public function register($username, $email, $password, $role,$status) {
        $newUser = new NewUserModel();
        $result = $newUser->addUser($username, $email, $password, $role, $status);

        if ($result) {
            switch ($role) {
                case "Teacher": 
                    header("Location: ../auth/accountStatus.php"); 
                    exit();
                case "Student":
                    header("Location: ../student/index.php");
                    exit();
            }
        } else {
            header('Location: ../auth/register.php?error=invalid_credentials');
            exit();
        }
    }
}
