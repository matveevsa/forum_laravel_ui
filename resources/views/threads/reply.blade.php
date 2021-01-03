<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>

                    <button class="btn btn-sm btn-primary" @click="update">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </div>

                <div v-else v-text="body"></div>
            </div>
            @can('update', $reply)
                <div class="card-footer flex">
                    <button class="btn btn-secondary btn-sm  mr-1" @click="editing = true">Edit</button>
                    <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
                </div>
            @endcan
        </div>
    </div>
</reply>