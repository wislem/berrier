<?php

namespace Wislem\Berrier\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\Node;

class Category extends Node
{
    use Translatable, Softdeletes;

    protected $translatedAttributes = ['slug', 'name'];
    protected $fillable = ['slug', 'name', 'icon', 'parent_id', '_lft', '_rgt'];


    public static function toJqTree()
    {
        return self::join('category_translations as t', 't.category_id', '=', 'categories.id')
            ->defaultOrder()->where('locale', '=', config('app.locale'))->get()->toTree();
    }
    
    public function widgets()
    {
        return $this->morphToMany(Widget::class, 'widgetable');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
