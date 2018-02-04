<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 22:23 AM
 */

namespace App\Repositories\Functions;

use App\Models\v1\OrderProduct;
use App\Repositories\Interfaces\OrderProductRepositoryContract;

class OrderProductRepository implements OrderProductRepositoryContract
{
    protected $model;

    public function __construct(OrderProduct $order_product)
    {
        $this->model = $order_product;
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

    public function deleteByOrder($id)
    {
        return $this->model->where('order_id', $id)->delete();
    }

}