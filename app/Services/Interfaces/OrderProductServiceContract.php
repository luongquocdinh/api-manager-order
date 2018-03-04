<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 22:18 AM
 */

namespace App\Services\Interfaces;

interface OrderProductServiceContract
{
    public function paginate($page);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function deleteByOrder($id);

    public function byDate($request, $id);

    public function byMonth($request, $id);

    public function byYear($request, $id);
}