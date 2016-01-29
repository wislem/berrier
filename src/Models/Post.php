<?php

namespace Wislem\Berrier\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Translatable;

    public $translatedAttributes = ['slug', 'title', 'content', 'meta_desc'];
    protected $fillable = ['slug', 'title', 'content', 'meta_desc', 'is_active'];

    public static function boot()
    {
        parent::boot();

        Post::deleting(function($post){
            // Delete all media associated with this item (iterated for media boot too)
            foreach($post->media as $medium) {
                $medium->delete();
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('ordr', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }
}
