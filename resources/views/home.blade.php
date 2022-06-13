@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (isset($started) && !$started)
                        <form action="{{ route('chat.begin') }}">
                            <button>Start Converstation</button>
                        </form>
                    @elseif (isset($started) && $started)
                        <div class="replies">
                            @foreach ($replies as $reply)
                                @if ($reply['sender'] == 'bot')
                                    <div class="reply bot">
                                        <p>{{ $reply['message'] }}</p>
                                    </div>
                                @elseif ($reply['sender'] == 'user')
                                    <div class="reply user">
                                        <p>{{ $reply['message'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('chat.reply') }}">
                            {{ csrf_field() }}
                            <input type="text" name="name">
                            <button>Submit</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
