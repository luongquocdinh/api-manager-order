<?php
/**
 * User: dinhlq
 * Date: 12/3/2018
 * Time: 20:20
 */

namespace App\Services\Interfaces;

interface SupplierProductServiceContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}