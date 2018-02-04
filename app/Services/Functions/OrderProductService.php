<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 22:19
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\OrderProductRepositoryContract;
use App\Services\Interfaces\OrderProductServiceContract;

class OrderProductService implements OrderProductServiceContract
{
    protected $repository;

    public function __construct(OrderProductRepositoryContract $repositoryContract)
    {
        $this->repository = $repositoryContract;
    }

    public function paginate($page)
    {
        return $this->repository->paginate($page);
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

    public function deleteByOrder($id)
    {
        return $this->repository->deleteByOrder($id);
    }

}