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

    public function displayCourse() {
        return [
            'type' => 'video',
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'videoUrl' => $this->videoUrl,
            'duration' => $this->duration,
            'tag' => $this->tag,
            'category' => $this->category
        ];
    }
}