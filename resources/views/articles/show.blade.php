@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $article->title }}</h1>
    <div class="mb-3">
        <strong>Author:</strong> {{ $article->user->name }}
    </div>
    <div class="mb-3">
        <strong>Publish Date:</strong> {{ $article->published_at ? $article->published_at->format('d M Y') : 'Not Published' }}
    </div>
    @if($article->image_path)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $article->image_path) }}" alt="Article Image" class="img-fluid">
        </div>
    @endif
    <div class="mb-3">
        <strong>Content:</strong>
        <p>{{ $article->content }}</p>
    </div>
    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to Articles</a>
</div>
@endsection
