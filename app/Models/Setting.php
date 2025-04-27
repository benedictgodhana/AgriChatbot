<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $group = 'general', $isPublic = true)
    {
        self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'is_public' => $isPublic
            ]
        );

        Cache::forget("setting.{$key}");
        return true;
    }

    /**
     * Get all settings as array
     */
    public static function getAll()
    {
        return Cache::rememberForever('settings.all', function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    public static function getAllSettings($group = null)
{
    $query = self::query();
    
    if ($group) {
        $query->where('group', $group);
    }

    $settings = $query->get();
    $formattedSettings = new \stdClass();

    foreach ($settings as $setting) {
        $formattedSettings->{$setting->key} = $setting->value;
    }

    return $formattedSettings;
}

}