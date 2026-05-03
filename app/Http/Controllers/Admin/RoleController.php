<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    // 📌 Role list
    public function index()
    {
        $roles = $this->service->getAll();
        return view('admin.roles.index', compact('roles'));
    }

    // 📌 Store role
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:roles'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $role = $this->service->store($request->all());

        return response()->json([
            'success'=>true,
            'role'=>$role
        ]);
    }

    // 📌 Edit role
    public function edit($id)
    {
        return response()->json(
            $this->service->getAll()->find($id)
        );
    }

    // 📌 Update role
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ],422);
        }

        $this->service->update($id,$request->all());

        return response()->json(['success'=>true]);
    }

    // 📌 Delete role
    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['success'=>true]);
    }
}