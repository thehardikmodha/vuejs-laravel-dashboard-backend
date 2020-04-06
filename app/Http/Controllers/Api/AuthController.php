<?php
/**
 * Created by MadBoy Developers.
 * Filename: AuthController.php
 * User: Hardik Modha
 * Date: 29/03/2020
 * Time: 7:57 AM
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResponse;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails())
            return new DefaultResponse([
               'status' => false,
               'message' => $validator->errors()->first(),
            ]);

        if (!Auth::attempt(request()->only(['email', 'password']))) {
            return new DefaultResponse([
                'status' => false,
                'message' => 'These credentials do not match our records.',
            ]);
        }

        $user = request()->user();
        $token = $user->createToken(env('APP_NAME', 'Optical Surface'));

        return new DefaultResponse([
            'status' => true,
            'message' => 'Successfully Logged in.',
            'data' => [
                'token' => $token->plainTextToken
            ],
        ]);
    }

    public function userData()
    {
        return new DefaultResponse([
            'status' => true,
            'message' => 'User data.',
            'data' => [
                'user' => new UserResource(Auth::user())
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return new DefaultResponse([
            'status' => true,
            'message' => 'successfully logged out.',
        ]);
    }
}
