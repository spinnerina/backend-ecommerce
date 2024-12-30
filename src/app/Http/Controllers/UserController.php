<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Login user
     * @OA\Post(
     *  path="/api/login",
     *  summary="Login user",
     *  tags={"Users"},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *         required={"email", "password"},
     *         @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *         @OA\Property(property="password", type="string", format="password", example="password")
     *     )
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Login successful",
     *     @OA\JsonContent(
     *        @OA\Property(property="token", type="string", example="2|3d4f5g6h7j8k9l0m1n2o3p4q5r6s7t8u9v0w1x2y3z4a5b6c7d8e9f0g1h2i3j4k5l6m7n8o9p0q1r2s3t4u5v6w7x8y9z0")
     *    )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Invalid credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Credenciales incorrectas")
     *    )
     *  )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            //Create token
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    /**
    * Logout user
    * @OA\Post(
    *   path="/api/logout",
    *   summary="Logout user",
    *   tags={"Users"},
    *   security={{"bearerAuth":{}}},
    *   @OA\Response(
    *     response=200,
    *     description="Logout successful",
    *     @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Sesión cerrada exitosamente")
    *     )
    *   )
    * )
    */
    public function destroy(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }
}
