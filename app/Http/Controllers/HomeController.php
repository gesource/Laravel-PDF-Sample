<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use tFPDF\PDF;
use Log;

class HomeController extends Controller
{
    public function index()
    {
        $pdf = new PDF();
        $pdf->AddPage('L','A4');

        // フォントの追加（第4引数をtrueにしてUTF-8を有効にする）
        $pdf->AddFont('mplus-1p-regular', '', 'mplus-1p-regular.ttf', true);
        $pdf->SetFont('mplus-1p-regular', '', 28);

        // テキストを追加
        $pdf->Write(8, 'test');

        // ページを追加
        $pdf->AddPage('P','A4');

        // 画像を追加(storage/image/01.jpgをPDFに追加する)
        $pdf->Image(storage_path('image/01.jpg'), 0, 0, 210, 297);

        return Response::make(
            $pdf->Output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="sample.pdf"'
            ]
        );
    }
}
