<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    // TODO:いい感じのテスト用エクセルシート作る（分かる範囲で　複数シートにしたり）->とりあえずDONE
    // TODO:DBにインポート可能にする->DONE
    // file not foundエラー出るので修正->DONE
    // TODO:テスト用シートでDB migrateする->DONE
    // ヘッダー無視->DONE
    // 列が25個と多いので対処。本来なら5→これ問題ないかもしれないな。とりあえずこの状態でインポートしてみる
    // ファイル削除（必要なら）
    // 空のrowをskip->DONE

    // エクセル、CSVどちらでやるか->ライブラリが使えるエクセルでいいと思う

    public function uploadFile(Request $request)
    {
        $file = $request->file("file");
        $fileName = $file->getClientOriginalName();
        $file->storeAs("public", $fileName);
        try {
            Excel::import(new BooksImport, $file);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return redirect("upload")->with("message", "ok" . $fileName);
    }
}
