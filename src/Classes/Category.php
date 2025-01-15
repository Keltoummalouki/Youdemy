<?php 

namespace App\Classes;

    class Category {
        private $id;
        private $category;

    public function __construct($id,$category){
        $this->id = $id;
        $this->category = $category;
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