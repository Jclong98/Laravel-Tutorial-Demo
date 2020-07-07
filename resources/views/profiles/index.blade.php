@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row border-bottom p-4">
        <div class="col-3">
            <img src="{{ $user->profile->profileImage() }}" alt="" class="border rounded-circle w-100" style="min-width:250px;">
        </div>
        <div class="col">
            <h3>
                {{ $user->username }} 
                <!-- <button class="btn btn-primary ml-4 px-2 py-1">Follow</button> -->

                <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>


                @can('update', $user->profile)
                    <a href="/profile/{{ $user->id }}/edit" class="btn border ml-3">Edit Profile</a>
                    <a href="/p/create" class="btn btn-primary float-right">Add New Post</a>
                @endcan

            </h3>

            <div class="row d-flex p-3">
                <div class="pr-5"><strong>{{ $postCount }}</strong>  posts</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
            </div>

            <strong>{{ $user->profile->title }}</strong>
            <p>{{ $user->profile->description }}</p>
            <a href="{{ $user->profile->url }}">{{ $user->profile->url }}</a>

        </div>
    </div>

    <div class="row pt-4">
        <!-- iterating each of the posts for this user -->
        @foreach($user->posts as $post)

            <div class="col-4 p-3">
                <!-- grabbing the source dynamically from each post object -->
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100 border rounded">
                </a>
            </div>

        @endforeach
    </div>
</div>
@endsection
