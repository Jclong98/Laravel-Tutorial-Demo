<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // removing protection because we are doing validation on patch
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function profileImage() {

        $imagePath = ($this->image) ? $this->image : 'profile/vazc1AQDkyqdCtvXpUqYx209XSvDQk8Mij5LDw29.png';

        return '/storage/' . $imagePath;
    }

    /**
     * many to many relationship with the following pivot table
     */
    public function followers() {
        return $this->belongsToMany(User::class);
    }
}
