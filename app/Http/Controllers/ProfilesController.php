<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities = $this->getActivty($user);

        return view('profile.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }
}
