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

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->getAll();
        $roles = Role::all();
        return view('admin.users.index', compact('users','roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $user = $this->service->store($request->all());

        return response()->json([
            'success'=>true,
            'user'=>$user
        ]);
    }

    public function edit($id)
    {
        $user = $this->service->getAll()->find($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $this->service->update($id, $request->all());

        return response()->json(['success'=>true]);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['success'=>true]);
    }
}