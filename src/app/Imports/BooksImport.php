<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

// SkipsEmptyRowsで空のrowをスキップ
class BooksImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Book([
            // gettype(trim(44930))=>stringになる
            "title" => $row[0],
            "author" => $row[1],
            "company" => $row[2],
            // スペースはis_numeric=>falsenになるので、is_numeric内でtrimする必要はない
            "published_at" => is_numeric($row[3]) ? Date::excelToDateTimeObject($row[3])->format("Y/m/d") : null,
            "increased_at" => is_numeric($row[4]) ? Date::excelToDateTimeObject($row[4])->format("Y/m/d") : null,
            "earnings" => $row[5],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
