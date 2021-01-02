@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="level">
                        <dvi class="flex">
                            <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                        </dvi>
                        @can ('delete', $thread)
                            <form action="{{ route('threads.destroy', [$thread->channel, $thread]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-link">Delete Thread</button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                   {{ $thread->body }}
                </div>
            </div>

            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
            <form action="{{ route('replies.store', $thread) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" class="form-control" placeholder="Have somthing to say?" rows="5"></textarea>
                </div>

                <button class="btn btn-primary">Submit</button>
            </form>
            @else
                <p class="text-center">
                    Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion
                </p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                   This thread was published {{ $thread->created_at->diffForHumans() }} by
                   <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
