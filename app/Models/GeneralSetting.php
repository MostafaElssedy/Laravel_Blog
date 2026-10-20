<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'blog_name',
        'blog_email',
        'blog_phone',
        'blog_meta_keywords',
        'blog_description',
        'blog_logo',
        'blog_favicon',
    ];

    protected static $cachedSettings = null;

    public static function getSettings()
    {
        if (self::$cachedSettings === null) {
            self::$cachedSettings = \Illuminate\Support\Facades\Cache::rememberForever('general_settings', function () {
                return self::first();
            });
        }
        return self::$cachedSettings;
    }
    
    public static function clearSettingsCache()
    {
        \Illuminate\Support\Facades\Cache::forget('general_settings');
        self::$cachedSettings = null;
    }
}
