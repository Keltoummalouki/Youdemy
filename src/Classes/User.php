<?php 

namespace App\Classes;

    class User {
        protected $id;
        protected $username;
        protected $email;
        protected $password;
        protected $role;

        
        public function __construct($id,$username,$email,$password,$role){
            return $this->id;
            return $this->username;
            return $this->email;
            return $this->password;
            return $this->role;
        }

        public function getId(){
            return $this->id;
        }

        public function getUserName(){
            return $this->username;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getRole(){
            return $this->role;
        }

        public function setUserName($username){
            $this->username = $username;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function setRole($role){
            $this->role = $role;
        }
    }