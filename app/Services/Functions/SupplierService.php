<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 02:31 AM
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\SupplierRepositoryContract;
use App\Services\Interfaces\SupplierServiceContract;

class SupplierService implements SupplierServiceContract
{
    protected $repository;

    public function __construct(SupplierRepositoryContract $repositoryContract)
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
}