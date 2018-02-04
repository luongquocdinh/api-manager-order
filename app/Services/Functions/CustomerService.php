<?php
/**
 * User: dinhlq
 * Date: 28/1/2018
 * Time: 11:05 AM
 */

namespace App\Services\Functions;

use App\Helpers\Business;
use App\Repositories\Interfaces\CustomerRepositoryContract;
use App\Services\Interfaces\CustomerServiceContract;

class CustomerService implements CustomerServiceContract
{
    protected $repository;

    public function __construct(CustomerRepositoryContract $repositoryContract)
    {
        $this->repository = $repositoryContract;
    }

    public function paginate($page)
    {
        return $this->repository->paginate($page);
    }

    public function getListAll()
    {
        return $this->repository->getListAll();
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