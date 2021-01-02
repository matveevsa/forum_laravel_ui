<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities = $this->getActivty($user);

        return view('profile.show', [
            'profileUser' => $user,
            'activities' => $activities
        ]);
    }

    protected function getActivty($user)
    {
        return $user
            ->activity()
            ->latest()
            ->with('subject')
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('d-m-Y');
            });
    }
}
