<?php

namespace App\Controllers;

use App\Classes\Tag;
use App\Models\TagModel;

class TagController {
    
    public function createTag($tag) {

        $newTag = new TagModel();
  
        $result = $newTag->addTag($tag);
    }

    public function deleteTag($tagId) {
        $deleteTag= new TagModel(); 
        $result = $deleteTag->removeTag($tagId);
        return $result;
    }

    public function updateTag($tagId, $newTag) {
        $updateTag= new TagModel();
        $result = $updateTag->editTag($tagId, $newTag);
        return $result;
    }

    public function getTagById ($tagId) {
        $updateTag = new TagModel();
        $result = $updateTag->getTagById($tagId);
        return $result;
    }


}

