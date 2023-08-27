<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            if ($request->password == $request->password_confirmed) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();


                $credentials = request(['email', 'password']);

                if (!$token = auth()->attempt($credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 43200,
                ]);
            }

            return response()->json("Password error");
        } catch (\Exception $e) {
            return response()->json("error: " . $e);
        }
    }
}
