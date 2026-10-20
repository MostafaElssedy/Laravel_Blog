<?php
use App\Models\ParentCategory;
use App\Models\Category;

// Dynamic Navigation menus
if (!function_exists('nav_menu_categories')) {
    function nav_menu_categories()
    {
        // Fetch parent categories that have subcategories with posts
        return ParentCategory::with(['subcategories' => function($query) {
            $query->has('posts');
        }])->whereHas('subcategories', function($query) {
            $query->has('posts');
        })->orderBy('ordering', 'asc')->get();
    }
}

?>
