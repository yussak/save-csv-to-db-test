<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BooksImport implements ToModel, WithStartRow, WithBatchInserts, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $isExists = DB::table("books")->where("author_id", $row[0])->exists();
        if ($isExists) {
            return null;
        }

        return new Book([
            "author_id" => $row[0],
            "title" => $row[1],
            "author" => $row[2],
            "company" => $row[3],
            "published_at" => is_numeric($row[4]) ? Date::excelToDateTimeObject($row[4])->format("Y/m/d") : null,
            "increased_at" => is_numeric($row[5]) ? Date::excelToDateTimeObject($row[5])->format("Y/m/d") : null,
            "earnings" => $row[6],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
