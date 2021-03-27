<?php

namespace App\Http\Controllers;

use App\Events\Register;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function confirmation($user, $hash)
    {
        $exp = request('expired');

        if (time() > $exp) {
            return response(['error' => 'link expired']);
        }

        $user = User::findOrFail($user);

        if ($user->email_verified_at != null) {
            return response(['error' => 'this account has been verified']);
        } else if (hash('sha256', $user->email) == $hash) {
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);

            return response(['status' => 'success verification']);
        } else {
            return response(['error' => 'token not found']);
        }
    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        event(new Register($user));

        return response(['success' => 'success resend email verification']);
    }
}
