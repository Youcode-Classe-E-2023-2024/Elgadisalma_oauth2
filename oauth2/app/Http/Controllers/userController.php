<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function addUser(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required|integer',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['message' => 'User added successfully', 'user' => $user], 201);
    
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);
        }
    
        $token = Str::random(60);
        $existingToken = DB::table('password_resets')->where('email', $user->email)->first();
    
        if ($existingToken) {
            DB::table('password_resets')->where('email', $user->email)->update(['token' => $token]);
        } else {
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => $token]);
        }
    
        Mail::send('forgot_password', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Réinitialisation du mot de passe');
        });
    
        return response()->json(['status' => 'success', 'message' => 'Password reset link sent to your email']);
    }
    
    public function reset(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        
            $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $validatedData['email'],
                'token' => $request->token
            ])->first();
        if (!$updatePassword) {
            return response()->json(['error' => 'invalid_token'], 400);
        }

        User::where('email', $validatedData['email'])
            ->update(['password' => Hash::make($validatedData['password'])]);

        DB::table('password_resets')->where('email', $validatedData['email'])->delete();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }


    public function editUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email' . $id,
            'password' => 'required',
            'role_id' => 'required|integer',
        ]);
    
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
    

        
        
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }
    

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        return response()->json(['message' => 'user deleted successfully'], 200);
    }


}
