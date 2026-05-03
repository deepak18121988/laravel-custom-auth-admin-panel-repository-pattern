<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $service;

    // 🔹 Service inject
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    // 📌 User list page
    public function index()
    {
        $users = $this->service->getAll(); // all users with role
        $roles = Role::all(); // dropdown

        return view('admin.users.index', compact('users','roles'));
    }

    // 📌 Store new user (AJAX)
    public function store(Request $request)
    {
        // 🔴 Validation
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role_id'=>'required'
        ]);

        // ❌ Return validation error
        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        // ✅ Create user
        $user = $this->service->store($request->all());

        // 🔥 Load role relation (IMPORTANT)
        $user->load('role');

        return response()->json([
            'success'=>true,
            'user'=>$user
        ]);
    }

    // 📌 Get single user (for edit modal)
    public function edit($id)
    {
        $user = $this->service->getAll()->find($id);
        return response()->json($user);
    }

    // 📌 Update user
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $this->service->update($id, $request->all());

        return response()->json(['success'=>true]);
    }

    // 📌 Delete user
    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['success'=>true]);
    }
}