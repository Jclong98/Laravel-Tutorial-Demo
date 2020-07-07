@extends('layouts.app')

@section('content')
<div class="container">
    <div class="border bg-white row rounded mt-5">
        <div class="col-8 p-0">
            <img src="/storage/{{ $post->image }}" alt="" class="w-100 border-right">
        </div>
        <div class="col p-0">
            <!-- top right corner section with profile pic and username -->
            <div class="border-bottom p-3 d-flex">
                <a href="/p/{{ $post->user->profile->profileImage() }}">
                    <img src="{{ $post->user->profile->profileImage() }}" class="border my-auto rounded-circle mr-2" style="width:2.5em">
                </a>
                <a style="color:black" href="/profile/{{ $post->user->id }}" class="my-auto font-weight-bold">{{ $post->user->username }}</a><span class="my-auto mx-2">•</span>
                <follow-button user-id="{{ $post->user->id }}" follows="{{ $follows }}"></follow-button>
            </div>

            <!-- description and comments section -->
            <div class="p-3">
                <img src="{{ $post->user->profile->profileImage() }}" class="border my-auto rounded-circle mr-2" style="width:2.5em">
                <a style="color:black" href="/profile/{{ $post->user->id }}" class="font-weight-bold">{{ $post->user->username }}</a> 
                {{ $post->caption }}
                <br>
                <small class="ml-5">{{ $post->created_at }}</small>
            </div>
        </div>
    
    </div>
</div>
@endsection
