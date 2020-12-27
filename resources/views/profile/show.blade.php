@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="jumbotron">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>
                @foreach ($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="level">
                                <span>
                                    <a href="{{ route('profile.show', $thread->creator) }}">
                                        {{ $thread->creator->name }}</a> posted:
                                    <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">
                                        {{ $thread->title }}
                                    </a>
                                </span>
                                <span>
                                    {{ $thread->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                        {{ $thread->body }}
                        </div>
                    </div>
                @endforeach
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection