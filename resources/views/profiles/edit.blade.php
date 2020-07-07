@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post" class="row border-bottom p-4">
        @csrf
        @method('PATCH')

        <div class="col-3">
            <label for="image" class="col-md-4 col-form-label btn p-0">
                <img src="{{ $user->profile->profileImage() }}" alt="" class="border rounded-circle w-100" style="min-width:250px;">
            </label>

            <input type="file" name="image" id="image" class="form-control-file">

            @error('image')
                <strong>{{ $errors->first('image') }}</strong>
            @enderror
        </div>

        <div class="col">
            <h3>
                {{ $user->username }} 
                <!-- <button class="btn btn-primary ml-4 px-2 py-1">Follow</button> -->

                <!-- <a href="/profile/{{ $user->id }}/edit" class="btn border ml-3">Edit Profile</a> -->


                <a href="/p/create" class="btn btn-primary float-right">Add New Post</a>
            </h3>

            <div class="row d-flex p-3">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong>  posts</div>
                <div class="pr-5"><strong>73</strong> followers</div>
                <div class="pr-5"><strong>82</strong> following</div>
            </div>

            

                <div class="form-group">
                    <input 
                        id="title" 
                        type="text" 
                        class="form-control @error('title') is-invalid @enderror" 
                        name="title" 
                        value="{{ old('title') ?? $user->profile->title }}" 
                        required autocomplete="title" autofocus
                        placeholder="title"
                    >

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">

                    <textarea 
                        name="description" 
                        id="description" 
                        cols="30" 
                        rows="10"
                        class="form-control @error('description') is-invalid @enderror" 
                        >{{ old('description') ?? $user->profile->description }}</textarea>

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input 
                        id="url" 
                        type="text" 
                        class="form-control @error('url') is-invalid @enderror" 
                        name="url" 
                        value="{{ old('url') ?? $user->profile->url }}" 
                        autocomplete="url"
                        placeholder="url"
                    >

                    @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('url') }}</strong>
                        </span>
                    @enderror
                </div>


                <button class="btn btn-primary btn-block">Confirm Changes</button>
            </form>

        </div>
    </form>

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
