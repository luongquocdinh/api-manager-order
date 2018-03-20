<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 02:32 AM
 */

namespace App\Repositories\Functions;

use App\Models\v1\Order;
use App\Repositories\Interfaces\OrderRepositoryContract;
use Illuminate\Support\Facades\DB;
use App\Helpers\Business;

class OrderRepository implements OrderRepositoryContract
{
    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
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

    public function findByCustomer($customer_id)
    {
        return $this->model->with('po_product')->where('customer_id', $customer_id)->get();
    }

    public function getOrderByDate($id, $start, $end, $request)
    {
        if (!$request->customer_id) {
            $results = $this->model
                            ->where('user_id', $id)
                            ->whereBetween('created_at', [$start, $end])
                            ->get();
        } else {
            $results = $this->model
                ->where('user_id', $id)
                ->where('customer_id', $request->customer_id)
                ->whereBetween('created_at', [$start, $end])
                ->get();
        }

        return $results;
    }

}