<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();

        return view('threads.index', compact('threads'));
    }

    public function show(Channel $channel, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $data['user_id'] = auth()->id();

        $thread = Thread::create($data);

        return redirect(route('threads.show', [$thread->channel, $thread]));
    }

    public function create()
    {
        return view('threads.create');
    }
}
