<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:23
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\SupplierProductRepositoryContract;
use App\Services\Interfaces\SupplierProductServiceContract;
use Carbon\Carbon;

class SupplierProductService implements SupplierProductServiceContract
{
    protected $repository;

    public function __construct(SupplierProductRepositoryContract $repositoryContract)
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
}