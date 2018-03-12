<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:32
 */

namespace App\Repositories\Functions;

use Illuminate\Support\Facades\DB;
use App\Models\v1\SupplierProduct;
use App\Repositories\Interfaces\SupplierProductRepositoryContract;

class SupplierProductRepository implements SupplierProductRepositoryContract
{
    protected $model;

    public function __construct(SupplierProduct $supplier_product)
    {
        $this->model = $supplier_product;
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