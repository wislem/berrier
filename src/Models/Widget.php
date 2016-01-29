<?php
namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'path', 'position', 'is_active', 'is_global', 'ordr'];

    public static function boot()
    {
        parent::boot();

        Widget::saved(function($widget){
            \Cache::tags('widgets')->flush();
        });
    }

    public function pages()
    {
        return $this->morphedByMany(Page::class, 'widgetable');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'widgetable');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'widgetable');
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function scopeGlobal($query)
    {
        return $query->whereIsGlobal(1);
    }

    public function scopeLocal($query)
    {
        return $query->whereIsGlobal(0);
    }
}
