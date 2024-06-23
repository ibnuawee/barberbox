@extends('layouts2.app')

@section('content')
    <div class="container">
        <h1>Chat Form</h1>

        <form id="sendMessageForm">
            @csrf
            <input type="hidden" id="recipient_id" name="recipient_id" value="1"> <!-- nilai recipient_id bisa diubah sesuai kebutuhan -->
            <textarea id="message" name="message"></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#sendMessageForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/send-message',
                type: 'POST',
                data: {
                    recipient_id: $('#recipient_id').val(),
                    message: $('#message').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Redirect to the chat view page
                    window.location.href = '/chat/' + $('#recipient_id').val();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
    </script>
@endsection


