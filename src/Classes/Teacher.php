<?php 

namespace App\Classes;

    class Teacher extends User {


        public function __construct($id,$username,$email,$password,$role){
            parent::__construct($id,$username,$email,$password,$role);
        }
    
    }