<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct() {

        // making sure that the user is signed in before they are able to follow
        $this->middleware('auth');
    }

    public function store(User $user) {
        
        // using authenticated user to toggle whether or not 
        // they are following the current page's profile

        return auth()->user()->following()->toggle($user->profile);
    }
}
