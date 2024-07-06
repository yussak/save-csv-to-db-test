<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class);

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

    it("Excel import成功したらリダイレクトされメッセージが表示される", function () {
        Excel::fake();
        $file = UploadedFile::fake()->create("file.xlsx");
        $response = $this->post("/upload", ["file" => $file]);

        $response->assertRedirect("/upload");
        $response->assertSessionHas("message", "ok");
    });

    it("テスト用ファイルを使用してDBにインポートし、個数が一致している", function () {
        $file = new UploadedFile(
            base_path("tests/resources/book.xlsx"),
            "book.xlsx",
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->post("/upload", ["file" => $file]);
        $this->assertDatabaseCount('books', 20);
    });
    it("Excel import時に例外発生したらロールバックされる")->todo();
    it("DBに保存されたレコード数とエクセルのデータ数が一致している")->todo();
    it("author_idが重複していない")->todo();
    it("空行はスキップされる")->todo();
    it("DBに保存されたデータが正しい")->todo();
    it("大量データのときに500エラーになる")->todo();

    // 未実装なのでテストできない
    it("エクセルの保存先テーブルが正しく割り当てられている")->todo();
    it("エクセルの保存先テーブルが見つからないとき例外をスロー")->todo();
    it("例外発生時にlaravelのエラー画面ではなくsessionメッセージが表示される")->todo();

    // 優先度は低い
    it("アップロード中に処理中の表示が出る")->todo();
});
