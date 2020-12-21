@extends('layouts.app')

@section('content')
    <div class="container">
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
                            {{ $thread->title }}
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
@endsection