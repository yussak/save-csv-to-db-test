<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

// 空行はこれでスキップされてそうだった
class BooksImport implements OnEachRow, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {
        // これがないとnot null violationが出る
        if (!isset($row[0])) {
            return null;
        }
        // すでにauthor_idがDBに入っているレコードと同じときはスキップ
        return Book::firstOrCreate(
            ["author_id" => $row[0]],
            [
                "author_id" => $row[0],
                "title" => $row[1],
                "author" => $row[2],
                "company" => $row[3],
                "published_at" => is_numeric($row[4]) ? Date::excelToDateTimeObject($row[4])->format("Y/m/d") : null,
                "increased_at" => is_numeric($row[5]) ? Date::excelToDateTimeObject($row[5])->format("Y/m/d") : null,
                "earnings" => $row[6],
            ]
        );
    }

    public function startRow(): int
    {
        return 2;
    }
}
