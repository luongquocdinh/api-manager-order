<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:30
 */

namespace App\Repositories\Interfaces;

interface SupplierRepositoryContract
{
    public function paginate($page, $id);

    public function getListAll($id);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}