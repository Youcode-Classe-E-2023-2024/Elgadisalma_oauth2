<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class permissionController extends Controller
{
    public function addPermission(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        return response()->json(['message' => 'permission added successfully', 'permission' => $permission], 201);
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        if (!$permission) {
            return response()->json(['message' => 'permission not found'], 404);
        }

        return response()->json(['message' => 'permission deleted successfully'], 200);
    }

    public function showPermissions()
    {
        $permissions = Permission::all();
        return response()->json(['message' => 'Liste des permissions', 'permissions' => $permissions], 200);
    }
}