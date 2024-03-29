<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Endpoint to log in a user",
     *     tags={"Authentication"},
     *     description="Logs in a user and returns an access token",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_at", type="string", format="date-time", example="2022-12-31 12:00:00"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }
        $user = $request->user();
        $token = $user->createToken('Access Token');
        $user->access_token = $token->accessToken;
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token->accessToken,

        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Endpoint to register a new user",
     *     tags={"Authentication"},
     *     description="Registers a new user",
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *     ),
     * )
     */
    public function register(Request $request)
    {
        // $defaultRole = Role::where('name', 'user')->first();

        // Create the user with the default role attached
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            "message" => "User registered successfully"
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Endpoint to log out a user",
     *     tags={"Authentication"},
     *     description="Logs out a user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged out successfully"),
     *         ),
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => "User logged out successfully"
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/index",
     *     summary="Endpoint to get a message",
     *     tags={"General"},
     *     description="Returns a message",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hello world"),
     *         ),
     *     ),
     * )
     */
  
    public function index()
    {
        return response()->json([
            'message' => 'Hello world'
        ], 200);
    }
}
