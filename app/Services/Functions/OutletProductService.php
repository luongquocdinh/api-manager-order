<?php
/**
 * User: dinhlq
 * Date: 5/3/2018
 * Time: 23:57
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\OutletProductRepositoryContract;
use App\Services\Interfaces\OutletProductServiceContract;
use Carbon\Carbon;

class OutletProductService implements OutletProductServiceContract
{
    protected $repository;

    public function __construct(OutletProductRepositoryContract $repositoryContract)
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