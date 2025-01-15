<?php 

namespace App\Classes;

    class Tag {
        private $id;
        private $tag;

        public function __construct($id,$tag){
            $this->id = $id;
            $this->tag = $tag;
        }

        public function getId(){
            return $this->id;
        }

        public function getTag(){
            return $this->tag;
        }

        public function setTag($tag){
            $this->tag = $tag;
        }
}