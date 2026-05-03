<?php
namespace App\Repositories\Admin;

use App\Models\Role;

class RoleRepository
{
    public function all()
    {
        return Role::all();
    }

    public function find($id)
    {
        return Role::findOrFail($id);
    }

    public function create($data)
    {
        return Role::create($data);
    }

    public function update($id, $data)
    {
        $role = $this->find($id);
        return $role->update($data);
    }

    public function delete($id)
    {
        return Role::destroy($id);
    }
}