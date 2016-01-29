<?php

namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = ['name', 'is_active', 'items'];

}