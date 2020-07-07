<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // tell laravel to not guard anything.
    // this lets you pass in the image and caption without restraint
    protected $guarded = [];

    /**
     * denotes the relationship to the User table
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
