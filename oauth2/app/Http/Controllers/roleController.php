<?php

namespace App\Http\Controllers;
use App\Models\Role;

use Illuminate\Http\Request;

class roleController extends Controller
{
    public function addRole(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->save();

        return response()->json(['message' => 'Role added successfully', 'role' => $role], 201);
    
    }
}
