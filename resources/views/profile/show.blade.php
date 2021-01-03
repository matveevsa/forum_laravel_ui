@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                    <h1 class="pb-2 mt-4 mb-2 border-bottom">
                        {{ $profileUser->name }}
                    </h1>
                @foreach ($activities as $date => $activity)
                    <h4 class="pb-2 mt-4 mb-2">{{ $date }}</h4>
                    @foreach ($activity as $record)
                        @if (view()->exists("profile.activities.{$record->type}"))
                            @include ("profile.activities.{$record->type}", ["activity" => $record])
                        @endif
                    @endforeach
                @endforeach
                {{-- {{ $threads->links() }} --}}
            </div>
        </div>
    </div>
@endsection