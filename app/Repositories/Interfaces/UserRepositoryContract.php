<?php
/**
 * User: dinhlq
 * Date: 30/1/2018
 * Time: 21:48 AM
 */

namespace App\Repositories\Interfaces;

interface UserRepositoryContract
{
    public function paginate($page);

    public function find($id);

    public function findByEmail($email);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}