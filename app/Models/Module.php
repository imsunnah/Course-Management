<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Module extends Model {

    // Use guarded to allow mass assignment for all fields
    protected $guarded = [];

    // Relationship: A module has many contents
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
