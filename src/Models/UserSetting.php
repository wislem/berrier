<?php

namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = 'usettings';

    protected $fillable = ['name', 'key', 'default', 'user_editable'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_usetting', 'usetting_id', 'user_id')->withPivot('value');
    }

    public function scopeUserEditable($query)
    {
        return $query->whereUserEditable(1);
    }
}
