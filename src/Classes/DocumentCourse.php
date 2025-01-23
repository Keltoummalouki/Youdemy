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
    
        public function displayCourse() {
            return [
                'type' => 'document',
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'documentFormat' => $this->documentFormat,
                'pageCount' => $this->pageCount,
                'tag' => $this->tag,
                'category' => $this->category
            ];
        }
    }
        