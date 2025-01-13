<?php 

namespace App\Classes;

    class Course {
        private $id;
        private $title;
        private $description;
        private $content;
        private $tag;
        private $category;

        public function __construct($id,$title,$description,$content,$tag,$category){
            return $this->id;
            return $this->title;
            return $this->description;
            return $this->content;
            return $this->tag;
            return $this->category;
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

    }