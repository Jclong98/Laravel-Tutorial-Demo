@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    
        <div class="col-7 offset-1">
            @foreach($posts as $post)

            <div class="border rounded mt-3 mb-5 bg-white">
                <div class="border-bottom p-3 d-flex">
                    <img src="{{ $post->user->profile->profileImage() }}" class="border my-auto rounded-circle mr-2" style="width:2.5em">
                    <a style="color:black" href="/profile/{{ $post->user->id }}" class="my-auto font-weight-bold">{{ $post->user->username }}</a>
                </div>

                <!-- image wrapped in an anchor to it's view page -->
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" alt="" class="w-100 border-bottom">
                </a>

                <div class="col p-0">

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

            @endforeach

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    <!-- when pagination is called in the controller, 
                    we get access to the links() method -->
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        <div class="col">

            <div class="row p-3">
                <a href="/profile/{{ auth()->user()->id }}">
                    <img src="{{ auth()->user()->profile->profileImage() }}" class="my-auto rounded-circle mr-2 border" style="width:5em">
                </a>
                <div class="my-auto">
                    <a style="color:black" href="/profile/{{ auth()->user()->id }}" class="font-weight-bold">{{ auth()->user()->username }}</a> <br>
                    {{ auth()->user()->name }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection