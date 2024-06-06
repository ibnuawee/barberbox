@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Articles</h1>
    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Create New Article</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publish Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->user->name }}</td>
                    <td>{{ $article->published_at ? $article->published_at->format('d M Y') : 'Not Published' }}</td>
                    <td>
                        @if($article->image_path)
                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="Article Image" width="100">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $articles->links() }}
</div>
@endsection
