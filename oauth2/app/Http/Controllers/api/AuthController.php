<?php

    namespace App\Http\Controllers\Api;

    use App\Models\Role;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;

    class AuthController extends Controller
    {
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


        public function register(Request $request)
        {
            $defaultRole = Role::where('name', 'user')->first();

            // Create the user with the default role attached
            $user = $defaultRole->users()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                "message" => "User registered successfully"
            ], 201);
        }

        public function update(Request $request, string $id)
        {
            //
        }

        public function logout(Request $request)
        {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => "User logged out successfully"
            ], 200);
        }

        public function index()
        {
            return response()->json([
                'message' => 'Hello world'
            ], 200);
        }
    }
