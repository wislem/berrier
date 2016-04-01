<?php
namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['slug', 'title', 'content', 'meta_desc'];
    protected $primaryKey = 't_id';

}