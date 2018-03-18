<?php
/**
 * User: dinhlq
 * Date: 29/1/2018
 * Time: 02:32 AM
 */

namespace App\Repositories\Interfaces;

interface OrderRepositoryContract
{
    public function paginate($page, $id);

    public function getListAll($id);

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function findByCustomer($customer_id);

    public function getOrderByDate($id, $start, $end);
}