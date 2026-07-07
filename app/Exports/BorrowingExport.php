<?php

namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;

class BorrowingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Borrowing::all();
    }
}
