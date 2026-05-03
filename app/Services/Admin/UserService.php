<?php
namespace App\Services\Admin;

use App\Repositories\Admin\UserRepository;

class UserService
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function store($data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        if(isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}