<?php 

namespace App\Classes;

    class DocumentCourse extends Course {
        private $documentFormat;
        private $pageCount;
    
        public function __construct($id, $title, $description, $content, $tag, $category, $documentFormat, $pageCount) {
            parent::__construct($id, $title, $description, $content, $tag, $category);
            $this->documentFormat = $documentFormat;
            $this->pageCount = $pageCount;
        }
    
        public function displayCourse($id, $title, $description, $content, $tag, $category) {
            return array_merge(parent::displayCourse($id, $title, $description, $content, $tag, $category), [
                'type' => 'document',
                'documentFormat' => $this->documentFormat,
                'pageCount' => $this->pageCount
            ]);
        }
    }
        