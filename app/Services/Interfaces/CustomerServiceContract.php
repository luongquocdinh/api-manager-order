<?php
/**
 * User: dinhlq
 * Date: 28/1/2018
 * Time: 11:04 AM
 */

namespace App\Services\Interfaces;

interface CustomerServiceContract
{
    public function paginate($page);

    public function getListAll();

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}