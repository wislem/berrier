<?php

namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['path', 'ordr'];

    public static function boot()
    {
        parent::boot();

        Media::deleting(function($medium){
            //Delete the actual file from disk
            \File::delete(storage_path().'/public'.$medium->path);
        });
    }

    public function mediable()
    {
        return $this->morphTo();
    }
}
