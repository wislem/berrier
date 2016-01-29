<?php

namespace Wislem\Berrier\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $searchableColumns = ['first_name', 'last_name', 'email', 'p_title'];

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'gender',
        'birthday', 'role', 'status', 'banned_reason', 'ip', 'last_login'];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['last_login'];

    public static function boot()
    {
        parent::boot();

        User::created(function($user){
            // Setup default user settings for the new user
            $usettings = UserSetting::lists('default', 'id')->toArray();
            if($usettings) {
                foreach ($usettings as $id => $value) {
                    $user_settings[$id] = ['value' => $value];
                }
                $user->settings()->sync($user_settings);
            }
        });
    }

    public function settings()
    {
        return $this->belongsToMany(UserSetting::class, 'user_usetting', 'user_id', 'usetting_id')->withPivot('value');
    }

    public function getFullNameAttribute()
    {
        return ($this->first_name or $this->last_name) ? $this->first_name . ' ' . $this->last_name : $this->nickname;
    }

    public function notifications($is_read = 0)
    {
        return $this->hasMany(Notification::class)->where('is_read', '=', $is_read)->orderBy('created_at', 'DESC');
    }
}
