<?php 

namespace App\Classes;

    class Category {
        private $id;
        private $category;
    public function __construct($id,$category){
        return $this->id;
        return $this->category;
    }

    public function getId(){
        return $this->id;
    }

    public function getCategory(){
        return $this->category;
    }

    public function setCategory($category){
        $this->category = $category;
    }

}