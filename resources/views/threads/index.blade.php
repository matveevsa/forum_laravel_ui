@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @forelse ($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header bg-white">
                            <div class="level">
                                <h4>
                                    <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">
                                    {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                @empty
                    <p>There are not relevant result at this time</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
