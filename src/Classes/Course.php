<?php 

namespace App\Classes;

    abstract class Course {
        private $id;
        private $title;
        private $description;
        private $content;
        private $tag;
        private $category;

        public function __construct($id,$title,$description,$content,$tag,$category){
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->content = $content;
            $this->tag = $tag;
            $this->category = $category;
        }

        public function getId(){
            return $this->id;
        }

        public function getTitle(){
            return $this->title;
        }

        public function getDescription(){
            return $this->description;
        }

        public function getContent(){
            return $this->content;
        }

        public function getTag(){
            return $this->tag;
        }

        public function getCategory(){
            return $this->category;
        }

        public function setTitle($title){
            $this->title = $title;
        }

        public function setDescription($description){
            $this->description = $description;
        }

        public function setContent($content){
            $this->content = $content;
        }

        public function setTag($tag){
            $this->tag = $tag;
        }

        public function setCategory($category){
            $this->category = $category;
        }

        abstract public function displayCourse($id,$title,$description,$content,$tag,$category);

    }