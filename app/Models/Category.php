<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;
    protected $fillable = ['name', 'slug', 'parent', 'ordering'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class, 'parent', 'id');
    }
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class, 'category_id');
    }
}
