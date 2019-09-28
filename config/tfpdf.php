<?php
if (!defined('FPDF_FONTPATH')) {
    define('FPDF_FONTPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR);
}

return [
    'FPDF_FONTPATH' => FPDF_FONTPATH,
];
