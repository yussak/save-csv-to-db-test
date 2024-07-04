<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

describe("file upload test", function () {
    it("ファイルが存在しない場合に例外をスロー", function () {
        $response = $this->post("/upload", ["file" => null]);

        $this->assertEquals('ファイルをアップロードしてください', $response->exception->getMessage());
    });
    it("ファイルの拡張子がxlsx以外のときに例外をスロー", function () {
        $file = UploadedFile::fake()->create("file.pdf");
        $response = $this->post("/upload", ["file" => $file]);

        $this->assertEquals(".xlsxのファイルをアップロードしてください", $response->exception->getMessage());
    });
    it("ファイルが正しいときにExcel importが呼び出される", function () {
        Excel::fake();
        $file = UploadedFile::fake()->create("file.xlsx");
        $this->post("/upload", ["file" => $file]);

        Excel::assertImported("file.xlsx");
    });
    it("Excel import時に例外発生したらロールバックされる")->todo();
    it("Excel import成功したらメッセージが表示される")->todo();
    it("DBに保存できる")->todo();
    it("DBに保存されたレコード数とエクセルのデータ数が一致している")->todo();
    it("author_idが重複していない")->todo();
    it("空行はスキップされる")->todo();
    it("DBに保存されたデータが正しい")->todo();
    it("大量データのときに500エラーになる")->todo();

    // 未実装なのでテストできない
    it("エクセルの保存先テーブルが正しく割り当てられている")->todo();
    it("エクセルの保存先テーブルが見つからないとき例外をスロー")->todo();
    it("例外発生時にlaravelのエラー画面ではなくsessionメッセージが表示される")->todo();
});
