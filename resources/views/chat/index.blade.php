@extends('layouts2.app')

@section('content')
<div class="container">
    <chat-component :user-id="{{ auth()->user()->id }}" :receiver-id="{{ $receiver_id }}"></chat-component>
</div>
@endsection
