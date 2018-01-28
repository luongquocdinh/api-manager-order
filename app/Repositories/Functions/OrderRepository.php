<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 02:32 AM
 */

namespace App\Repositories\Functions;

use App\Models\v1\Order;
use App\Repositories\Interfaces\OrderRepositoryContract;

class OrderRepository implements OrderRepositoryContract
{
    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function paginate($page)
    {
        return $this->model->paginate($page);
    }

    public function find($id)
    {
        return $this->model->find($id);
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