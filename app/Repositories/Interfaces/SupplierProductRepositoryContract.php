<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:31
 */

namespace App\Repositories\Interfaces;

interface SupplierProductRepositoryContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}