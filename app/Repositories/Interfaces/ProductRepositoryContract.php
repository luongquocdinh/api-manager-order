<?php
/**
 * User: dinhlq
 * Date: 26/1/2018
 * Time: 22:15 AM
 */

namespace App\Repositories\Interfaces;

interface ProductRepositoryContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}