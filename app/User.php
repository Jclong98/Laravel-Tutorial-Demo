<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserWelcomeMail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * happens when an instance of User is created
     */
    protected static function boot() {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);

            // send a verification email
            Mail::to($user->email)->send(new NewUserWelcomeMail());

        });
    }

    /**
     * one to many relationship to the Post table
     */
    public function posts() {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    /**
     * one to one relationship to the Profile table
     */    
    public function profile() {
        return $this->hasOne(Profile::class);
    }

    /**
     * many to many relationship with the following pivot table
     */
    public function following() {
        return $this->belongsToMany(Profile::class);
    }
}
