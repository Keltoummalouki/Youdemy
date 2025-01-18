<?php 

namespace App\Classes;

class VideoCourse extends Course {
    private $videoUrl;
    private $duration;

    public function __construct($id, $title, $description, $content, $tag, $category, $videoUrl, $duration) {
        parent::__construct($id, $title, $description, $content, $tag, $category);
        $this->videoUrl = $videoUrl;
        $this->duration = $duration;
    }

    public function displayCourse($id, $title, $description, $content, $tag, $category) {
        return [
            'type' => 'video',
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'videoUrl' => $this->videoUrl,
            'duration' => $this->duration,
            'tag' => $tag,
            'category' => $category
        ];
    }
}