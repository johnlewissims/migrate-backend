<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Storage;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
class AuthController extends Controller
{
    public function register(UserRegisterRequest $request) {
      $user = User::create([
        'email' => $request->email,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'role' => $request->role[0],
        'company' => $request->company,
        'password' => bcrypt($request->password),
      ]);

      if(!$token = auth()->attempt($request->only(['email', 'password']))) {
        return abort(401);
      };

      $path = $request->user()->id;
      Storage::makeDirectory($path);

      return (new UserResource($request->user()))->additional([
        'meta' => [
          'token' => $token,
        ],
      ]);
    }

    public function login(UserLoginRequest $request) {
      if(!$token = auth()->attempt($request->only(['email', 'password']))) {
        return response()->json([
          'errors' => [
            'email' => ['Sorry, we the username or password is incorrect.'],
          ],
        ], 422);
      }

      return (new UserResource($request->user()))->additional([
        'meta' => [
          'token' => $token,
        ],
      ]);
    }

    public function user(Request $request){
      return new UserResource($request->user());
    }

    public function logout(Request $request){
      auth()->logout();
    }
}
