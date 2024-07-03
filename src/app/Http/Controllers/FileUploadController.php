<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    // Booksテーブルにインポート可能にする->done
    // ヘッダー無視->done
    // ファイル削除（必要なら）->現状必要ないので実装していない
    // 空のrowをskip->done
    // フラッシュメッセージ出したい->メッセージ自体は出せているので優先度低い

    // 値の重複チェック
    // 複数シートを個別のテーブルに保存できるようにする

    // テスト実装->これ次にやるべき

    public function uploadFile(Request $request)
    {
        $file = $request->file("file");
        if ($file->getClientOriginalExtension() !== "xlsx") {
            throw new Exception(".xlsxのファイルをアップロードしてください");
        }

        $fileName = $file->getClientOriginalName();

        try {
            Excel::import(new BooksImport, $file);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return redirect("upload")->with("message", "ok" . $fileName);
    }
}
