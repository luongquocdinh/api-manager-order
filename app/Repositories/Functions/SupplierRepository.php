<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:31
 */

namespace App\Repositories\Functions;

use App\Models\v1\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryContract;
use App\Helpers\Business;

class SupplierRepository implements SupplierRepositoryContract
{
    protected $model;

    public function __construct(Supplier $supplier)
    {
        $this->model = $supplier;
    }

    public function paginate($page, $id)
    {
        return $this->model->with('product')->where('created_by', $id)->paginate($page);
    }

    public function getListAll($id)
    {
        return $this->model->with('product')->where('user_id', $id)->orderBy('id', 'desc')->get();
    }

    public function find($id)
    {
        return $this->model->with('product')->find($id);
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