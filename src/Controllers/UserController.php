<?php

namespace App\Controllers;

use App\Config\DatabaseConnexion;
use App\Models\UserModel;
use PDO;

class UserController {
    
    public function deleteUser($userId) {

        $deleteUser = new UserModel(); 

        $result = $deleteUser->removeuser($userId);

        return $result;
    }
}
