<?php

namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = 'usettings';

    protected $fillable = ['name', 'key', 'default', 'user_editable'];

    public static function boot()
    {
        parent::boot();

        self::created(function($usetting){

            $users = User::all();
            foreach($users as $user) {
                $user->settings()->attach($usetting);
            }
        });
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_usetting', 'usetting_id', 'user_id')->withPivot('value');
    }

    public function scopeUserEditable($query)
    {
        return $query->whereUserEditable(1);
    }
}
