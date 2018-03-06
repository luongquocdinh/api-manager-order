<?php
/**
 * User: dinhlq
 * Date: 5/3/2018
 * Time: 23:58
 */

namespace App\Repositories\Functions;

use Illuminate\Support\Facades\DB;
use App\Models\v1\OutletProduct;
use App\Repositories\Interfaces\OutletProductRepositoryContract;

class OutletProductRepository implements OutletProductRepositoryContract
{
    protected $model;

    public function __construct(OutletProduct $outlet_product)
    {
        $this->model = $outlet_product;
    }

    public function paginate($page)
    {
        return $this->model->with(['user', 'product'])->paginate($page);
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