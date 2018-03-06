<?php
/**
 * User: dinhlq
 * Date: 5/3/2018
 * Time: 23:57
 */

namespace App\Repositories\Interfaces;

interface OutletProductRepositoryContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}