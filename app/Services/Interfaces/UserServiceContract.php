<?php
/**
 * User: dinhlq
 * Date: 30/1/2018
 * Time: 21:42 AM
 */

namespace App\Services\Interfaces;

interface UserServiceContract
{
    public function paginate($page);

    public function find($id);

    public function findByEmail($email);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function findUserByCode($request);
}