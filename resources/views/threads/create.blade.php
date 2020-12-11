@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('threads.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="channel_id">Chose a Channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose one...</option>
                                @foreach ($channels as $channel)
                                    <option
                                        value="{{ $channel->id }}"
                                        {{ old('channel_id') == $channel->id ? 'selected' : '' }}
                                    >
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input required type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea type="text" class="form-control" id="body" rows="5" name="body" required></textarea>
                        </div>

                        @if (count($errors))
                            @foreach( $errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
                        @endif
                        <button class="btn btn-primary">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
