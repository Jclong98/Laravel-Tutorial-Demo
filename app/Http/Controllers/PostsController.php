<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    /**
     * constructor
     */
    public function __construct() {
        // requiring authorization to visit routes from this controller
        $this->middleware('auth');
    }

    /**
     * show posts of people you are following
     */
    public function index() {
        // using the pluck method to only grab one of the columns in the profiles table
        $users = auth()->user()->following()->pluck('profiles.user_id');

        // getting the posts in reverse chronological order
        // latest() is short for orderBy('created_at', 'DESC')
        // with('user') so that when it paginates it is more efficiently pulling from the user table
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact('posts'));

    }

    /**
     * goes to the create form
     */
    public function create() {
        return view('posts.create');
    }

    /**
     * stores data from the create form
     */
    public function store() {
        
        // validate request
        $data = request()->validate([
            'caption' => 'required',

            // validating that the image is required and an image
            'image' => ['required', 'image'],
        ]);

        // first param is path to storage, second is driver
        $imagePath = request('image')->store('uploads', 'public');

        // cutting the excess and fitting the image to 1200 x 1200px
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        

        // get the authenticated user with auth()
        // create post in database after validation
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        // redirecting the user back to their profile
        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * show a specific post
     * type hinting \App\Post lets laravel to know to use the Post model
     */
    public function show(\App\Post $post) {
        // following false to default
        $follows = false;

        // if an authenticated user is logged in, 
        // see if its following list contains current pages user_id
        if (auth()->user()) {
            $follows = auth()->user()->following->contains($post->user->id);
        }

        // compact matches the variable named post into a list?
        return view('posts.show', compact('post', 'follows'));
    }
}
