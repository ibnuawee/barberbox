@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Article</h1>
    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $article->title }}" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $article->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="published_at">Publish Date:</label>
            <input type="date" name="published_at" id="published_at" class="form-control" value="{{ $article->published_at ? $article->published_at->format('Y-m-d') : '' }}">
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($article->image_path)
                <img src="{{ asset('storage/' . $article->image_path) }}" alt="Article Image" width="100">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
