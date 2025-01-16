<?php

namespace App\Controllers;

use App\Classes\Category;
use App\Models\CategoryModel;

class CategoryController {
    
    public function createCategory($category) {

        $newCategory = new CategoryModel();
  
        $result = $newCategory->addCategory($category);
    }

    public function deleteCategory($categoryId) {

        $deleteCategory = new CategoryModel(); 

        $result = $deleteCategory->removeCategory($categoryId);

        return $result;
    }

    public function updateCategory($categoryId, $newCategory) {

        $updateCategory = new CategoryModel();

        $result = $updateCategory->editCategory($categoryId, $newCategory);

        return $result;
    }

    public function getCategoryById ($categoryId) {

        $updateCategory = new CategoryModel();

        $result = $updateCategory->getCategoryById($categoryId);
        
        return $result;
    }



}

