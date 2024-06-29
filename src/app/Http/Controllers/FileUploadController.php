<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    // いい感じのテスト用エクセルシート作る（分かる範囲で　複数シートにしたり）->とりあえずDONE
    // DBにインポート可能にする->DONE
    // file not foundエラー出るので修正->DONE
    // テスト用シートでDB migrateする->DONE
    // ヘッダー無視->DONE
    // 列が25個と多いので対処。本来なら5→これ問題ないかもしれないな。とりあえずこの状態でインポートしてみる
    // ファイル削除（必要なら）->現状必要ないので実装していない
    // 空のrowをskip->DONE
    // エラーハンドリング追加　拡張子の分
    // エラーハンドリング追加　その他の分
    // フラッシュメッセージ出したい

    // エクセル、CSVどちらでやるか->ライブラリが使えるエクセルでいいと思う

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
