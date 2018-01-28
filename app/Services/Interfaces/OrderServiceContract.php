<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 02:30 AM
 */

namespace App\Services\Interfaces;

interface OrderServiceContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}