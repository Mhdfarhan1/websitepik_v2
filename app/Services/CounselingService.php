<?php

namespace App\Services;

use App\Models\Counseling;

class CounselingService
{
    public function getPaginatedItems($perPage = 10)
    {
        return Counseling::latest()->paginate($perPage);
    }

    public function getAllItems()
    {
        return Counseling::latest()->get();
    }

    public function createItem(array $data)
    {
        return Counseling::create($data);
    }

    public function updateItem(Counseling $counseling, array $data)
    {
        $counseling->update($data);
        return $counseling;
    }

    public function deleteItem(Counseling $counseling)
    {
        return $counseling->delete();
    }
}
