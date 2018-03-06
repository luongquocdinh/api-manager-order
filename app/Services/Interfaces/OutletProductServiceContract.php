<?php
/**
 * User: dinhlq
 * Date: 5/3/2018
 * Time: 23:55
 */

namespace App\Services\Interfaces;

interface OutletProductServiceContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}