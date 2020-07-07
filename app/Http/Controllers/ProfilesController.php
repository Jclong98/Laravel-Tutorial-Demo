<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    /**
     * Show a user's profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {

        // dd is a useful dev function that shows what a variable is
        // dd($user);

        // following false to default
        $follows = false;

        // if an authenticated user is logged in, 
        // see if its following list contains current pages user_id
        if (auth()->user()) {
            $follows = auth()->user()->following->contains($user->id);
        }


        // caching the posts, followers and following counts
        // Cache::remember takes a unique cache key, number of seconds, and a callback to return what is cached
        // not sure what use ($user) does specifically, but it lets us use $user in the function
        $postCount = Cache::remember(
            'count.posts.' . $user->id, 
            now()->addSeconds(30), 
            function() use ($user) {
                return $user->posts->count();
            }
        );

        $followersCount = Cache::remember(
            'count.followers.' . $user->id, 
            now()->addSeconds(30), 
            function() use ($user) {
                return $user->profile->followers->count();
            }
        );

        $followingCount = Cache::remember(
            'count.following.' . $user->id, 
            now()->addSeconds(30), 
            function() use ($user) {
                return $user->following->count();
            }
        );
        

        // return the index view from the profiles folder
        // compact allows us to access these variables inside the blade templates
        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    /**
     * edit the profile
     */
    public function edit(User $user) {
        // using the profile policy to validate that the 
        // user has access to the account
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    /**
     * updates a profile
     */
    public function update(User $user) {
        // using the profile policy to validate that the 
        // user has access to the account
        $this->authorize('update', $user->profile);

        // validate request
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        // if the user did upload a new image
        if (request('image')) {
            // first param is path to storage, second is driver
            $imagePath = request('image')->store('profile', 'public');
            
            // cutting the excess and fitting the image to 1200 x 1200px
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            // setting an image array to be merged with data if there is an uploaded image
            $imageArray = ['image' => $imagePath];
        }
        
        // updating the data in the authenticated user's profile
        // overriding the image parameter of the profile to the path of the image
        auth()->user()->profile->update(array_merge(
            $data, 
            $imageArray ?? [],
        ));
        

        // redirecting the user back to their profile
        return redirect('/profile/' . auth()->user()->id);
    }
}