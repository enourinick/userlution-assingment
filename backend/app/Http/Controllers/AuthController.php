<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

 
class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $credentials = $request->all();
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json(['user' => $user]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        // $request->user()->tokens()->delete();

       // $cookie = Cookie::forget('auth-token');

        return response()->json(['message' => 'Logout successful']);//->withCookie($cookie);
    }
}