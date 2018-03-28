<?php
/**
 * User: dinhlq
 * Date: 30/1/2018
 * Time: 21:49 AM
 */

namespace App\Repositories\Functions;

use App\Models\v1\User;
use App\Repositories\Interfaces\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function paginate($page)
    {
        return $this->model->paginate($page);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }


    public function store($data)
    {
        return $this->model->create($data)->id;
    }

    public function update($id, $data)
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }
        $model->update($data);

        return true;
    }

    public function destroy($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }

    public function findUserByCode($request)
    {
        return $this->model
            ->where('email', $request->email)
            ->where('api_token', $request->code)
            ->first();
    }

}