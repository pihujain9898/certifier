<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class ImportExcel implements ToCollection
{
    private $id;
    public function __construct(int $id) 
    {
        $this->id = $id;
    }

    public function collection(Collection $arr)
    {
        return DB::table('data')->updateOrInsert(
            ['id' => $this->id],
            ['datasrc' => json_encode($arr->toArray())]
        );
    }
}
