<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\AuthLogInRequest;
use App\Http\Resources\AuthLogInResource;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * login
     *
     * @param AuthLogInRequest $request
     * @return AuthLogInResource
     */
    public function login(AuthLogInRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (!Hash::check($request->password, $user->password)) {
            /*   throw ValidationException::withMessages([
                  'email' => ['wrong credentials'],
                  ]);
            */

            abort(422, 'invalid credential');

        }
        return new AuthLogInResource($user);


    }
}
