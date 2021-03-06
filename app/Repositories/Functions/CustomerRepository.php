<?php
/**
 * User: dinhlq
 * Date: 28/1/2018
 * Time: 11:08 AM
 */

namespace App\Repositories\Functions;

use App\Models\v1\Customer;
use App\Repositories\Interfaces\CustomerRepositoryContract;

class CustomerRepository implements CustomerRepositoryContract
{
    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function paginate($page, $id)
    {
        return $this->model->where('created_by', $id)->paginate($page);
    }

    public function getListAll($id)
    {
        return $this->model->where('user_id', $id)->orderBy('id', 'desc')->get();
    }

    public function find($id)
    {
        return $this->model->with('order')->find($id);
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

}