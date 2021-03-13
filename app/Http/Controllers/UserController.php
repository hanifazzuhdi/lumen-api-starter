<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show()
    {
        $user = $this->user->find(Auth::id());

        return $this->sendResponse('success', 'data user has been loaded', $user, 200);
    }
}
