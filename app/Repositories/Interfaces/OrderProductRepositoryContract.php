<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 22:21
 */

namespace App\Repositories\Interfaces;

interface OrderProductRepositoryContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function deleteByOrder($id);

    public function byMonth($request, $id);
}