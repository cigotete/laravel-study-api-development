<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function validateUser(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        if (Hash::check($request->password, $user->password)) {
            return UserResource::make($user);
        } else {
            return response()->json(['message' => 'These credentials do not match our records.'], 404);
        }
    }
}
