<?php
namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['slug', 'title', 'content', 'meta_desc'];

}