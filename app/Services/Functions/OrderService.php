<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 02:31 AM
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\OrderRepositoryContract;
use App\Services\Interfaces\OrderServiceContract;
use Carbon\Carbon;

class OrderService implements OrderServiceContract
{
    protected $repository;

    public function __construct(OrderRepositoryContract $repositoryContract)
    {
        $this->repository = $repositoryContract;
    }

    public function paginate($page, $id)
    {
        return $this->repository->paginate($page, $id);
    }

    public function getListAll($id)
    {
        return $this->repository->getListAll($id);
    }

    public function find($id)
    {
        return $this->repository->find($id);
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

    public function findByCustomer($customer_id)
    {
        return $this->repository->findByCustomer($customer_id);
    }

    public function getOrderByDate($id, $request)
    {
        $start = Carbon::parse($request->start . ' 00:00:00')->timestamp;
        $end = Carbon::parse($request->end . ' 23:59:59')->timestamp;

        return $this->repository->getOrderByDate($id, $start, $end);
    }

}