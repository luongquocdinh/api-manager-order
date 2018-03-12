<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:19
 */

namespace App\Services\Interfaces;

interface SupplierServiceContract
{
    public function paginate($page, $id);

    public function getListAll($id);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}