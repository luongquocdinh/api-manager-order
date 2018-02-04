<?php
/**
 * User: dinhlq
 * Date: 26/1/2018
 * Time: 22:19 AM
 */

namespace App\Repositories\Functions;

use App\Models\v1\Product;
use App\Repositories\Interfaces\ProductRepositoryContract;

class ProductRepository implements ProductRepositoryContract
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function paginate($page)
    {
        return $this->model->paginate($page);
    }

    public function getListAll()
    {
        return $this->model->All();
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