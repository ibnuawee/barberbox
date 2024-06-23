@extends('layouts2.app')

@section('content')
<div class="container">
    <h1>Chat</h1>
    <chat-component :user-id="{{ auth()->user()->id }}" :receiver-id="{{ $receiverId }}"></chat-component>
</div>
@endsection
