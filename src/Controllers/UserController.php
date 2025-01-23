<?php

namespace App\Controllers;

use App\Config\DatabaseConnexion;
use App\Models\UserModel;
use PDO;

class UserController {
    
    public function deleteUser($userId) {

        $deleteUser = new UserModel(); 

        $result = $deleteUser->removeUser($userId);

        return $result;
    }

    public function updateUserStatus($userId, $newStatus){
        $userDashModel = new UserModel(); 

        $result = $userDashModel->updateUserStatus($userId, $newStatus);

        if ($result) {
            header("Location: ./dashboard.php");
            exit();
        } 
    }

}
