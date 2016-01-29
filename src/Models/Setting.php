<?php

namespace Wislem\Berrier\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Setting extends Model
{

    protected $fillable = ['name', 'key', 'value'];

    /**
     * Retrieve a specific setting from DB based on key
     *
     * @param string $key
     * @return bool|mixed
     */
    public static function get($key = '')
    {
        if($key) {
            if(Cache::has('settings.'.$key)) {
                $value = Cache::get('settings.'.$key);
            }else {
                $value = Setting::whereKey($key)->pluck('value');
                Cache::forever('settings.'.$key, $value);
            }

            return $value;
        }

        return false;
    }

    /**
     * Sets a value to a specific setting key in DB
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public static function set($key = '', $value = '')
    {
        if($key and $value) {
            Cache::forget('settings.'.$key);
            Setting::whereKey($key)->update(['value' => $value]);
            Cache::forever('settings.'.$key, $value);
        }

        return false;
    }
}
