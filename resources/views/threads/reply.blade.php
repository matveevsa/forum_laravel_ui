<div class="mb-2">
    <div class="card card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="#">
                        {{ $reply->owner->name }}
                    </a>
                     said {{ $reply->created_at->diffForHumans() }}...
                </h5>
                <div>
                    <form method="POST" action="{{ route('reply_favorite', $reply->id) }}">
                        @csrf
                        <button class="btn btn-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ Str::plural('favorite', $reply->favorites_count) }}
                        </button>,
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $reply->body }}
        </div>
    </div>
</div>