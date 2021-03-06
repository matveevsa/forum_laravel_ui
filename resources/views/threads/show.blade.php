@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="level">
                            <div>
                                <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </div>
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

                <replies @added="repliesCount++" @remove="repliesCount--"></replies>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="{{ route('profile.show', $thread->creator) }}">
                            {{ $thread->creator->name }}
                        </a>, and currently has <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                        <div class="mt-3">
                            <subscribe-button active="{{ $thread->isSubscribedTo }}"></subscribe-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
