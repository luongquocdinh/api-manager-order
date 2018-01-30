<?php
/**
 * User: dinhlq
 * Date: 30/1/2018
 * Time: 21:43 AM
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Services\Interfaces\UserServiceContract;

class UserService implements UserServiceContract
{
    protected $repository;

    public function __construct(UserRepositoryContract $repositoryContract)
    {
        $this->repository = $repositoryContract;
    }

    public function paginate($page)
    {
        return $this->repository->paginate($page);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findByEmail($email)
    {
        return $this->repository->findByEmail($email);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

}