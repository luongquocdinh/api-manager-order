<?php
/**
 * User: dinhlq
 * Date: 26/1/2018
 * Time: 22:14 AM
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\ProductRepositoryContract;
use App\Services\Interfaces\ProductServiceContract;

class ProductService implements ProductServiceContract
{
    protected $repository;

    public function __construct(ProductRepositoryContract $repositoryContract)
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