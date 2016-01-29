<?php

namespace Wislem\Berrier\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Translatable;

    public $translatedAttributes = ['slug', 'title', 'content', 'meta_desc'];
    protected $fillable = ['slug', 'title', 'content', 'meta_desc', 'is_active'];

    public function widgets()
    {
        return $this->morphToMany(Widget::class, 'widgetable');
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }
}
