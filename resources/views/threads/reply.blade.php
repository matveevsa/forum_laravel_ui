<div class="mb-2">
    <div class="card" id="reply-{{ $reply->id }}">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile.show', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a>
                     said {{ $reply->created_at->diffForHumans() }}...
                </h5>
                <div>
                    <form method="POST" action="{{ route('reply_favorite', $reply->id) }}">
                        @csrf
                        <button class="btn btn-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ Str::plural('favorite', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $reply->body }}
        </div>
        @can('delete', $reply)
            <div class="card-footer">
                <form method="POST" action="{{ route('replies.destroy', $reply) }}">
                    @csrf
                    @method('DELETE')

                    <button type='submit' class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</div>