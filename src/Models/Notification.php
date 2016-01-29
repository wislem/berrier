<?php

namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['content', 'user_id', 'uri', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
