@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5">
            <div class="card card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted:
                    {{ $thread->title }}
                </div>
                <div class="card-body">
                   {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach($thread->replies as $reply)
           @include('threads.reply')
        @endforeach
    </div>

    @if (auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5">
            <form action="{{ route('replies.store', $thread) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" class="form-control" placeholder="Have somthing to say?" rows="5"></textarea>
                </div>

                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    @else
        <p class="text-center">
            Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion
        </p>
    @endif
</div>
@endsection
