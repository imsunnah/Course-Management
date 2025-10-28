<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Module extends Model
{

    protected $guarded = [];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
    protected static function booted()
    {
        static::deleting(function ($module) {
            $module->contents()->delete();
        });
    }
}
