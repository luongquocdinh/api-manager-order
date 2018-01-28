<?php
/**
 * User: dinhlq
 * Date: 28/1/2018
 * Time: 11:07 AM
 */

namespace App\Repositories\Interfaces;

interface CustomerRepositoryContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}