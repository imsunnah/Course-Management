<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function modules() {
        return $this->hasMany(Module::class);
    }
public function getRouteKeyName()
{
    return 'slug';
}
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = $course->generateUniqueSlug($course->title);
        });

        static::updating(function ($course) {
            $course->slug = $course->generateUniqueSlug($course->title, $course->id);
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function generateUniqueSlug($name, $acceptId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->where('id', '!=', $acceptId)->exists()) {
            $slug = $counter.'-'.$originalSlug;
            $counter++;
        }

        return $slug;
    }
}

