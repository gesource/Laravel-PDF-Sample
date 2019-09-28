# Laravel-PDF-Sample

LaravelでPDFファイルを作成し、ダウンロードする

## 環境

* Laravel 5.5
* docnet/tfpdf

## tFPDF

[tFPDF](http://www.fpdf.org/en/script/script92.php)は[FPDF](http://www.fpdf.org/)をUTF-8サポートしたライブラリ。

公式のcomposerのパッケージはないが、非公式なパッケージならいくつか見つかる。

今回はdocnet/tfpdfを使用する。

## インストール

docnet/tfpdfをインストールする。

    $ composer require docnet/tfpdf

## 日本語フォントの設定

tFPDFで使用する日本語フォントを設定する。

resourcesフォルダーにfontフォルダーを作成し、その中にunifontフォルダーを作成する。

    $ mkdir -p resources/font/unifont

unifontフォルダーのアクセス権を設定する。  
設定しなくても動作するが、設定するとフォントの設定がキャッシュされ、実行速度が向上する。

    $ chmod 755 resources/font/unifont

unifontフォルダーの中に使用するフォントファイルを配置する。  
ここでは[mplusフォント](https://mplus-fonts.osdn.jp)を使用する。

    resources/
        font/
            unifont/
                mplus-1p-regular.ttf

フォントを配置したフォルダーをfTPDFに反映する。

configフォルダーにtfpdf.phpを作成し、定数FPDF_FONTPATHにフォントフォルダーのパスを設定する。

    <?php
    if (!defined('FPDF_FONTPATH')) {
        define(
            'FPDF_FONTPATH',
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR
        );    
    }

## PDFの作成

PDFを作成してダウンロードさせる。

コードの説明は、ソースコード内のコメントを参照。

    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Response;
    use tFPDF\PDF;

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
