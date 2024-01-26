<?php

namespace App\Services;

use App\Contracts\FileCompressor;
use ZipArchive;

class ZipFileCompressor implements FileCompressor
{
    public function compress($filePath, $outputFormat): void
    {
        // انجام فشرده‌سازی بر اساس فرمت مورد نظر
        $zip = new ZipArchive();
        $zipFileName = pathinfo($filePath, PATHINFO_FILENAME) . '.' . $outputFormat;

        $storagePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($storagePath, ZipArchive::CREATE)) {
            $zip->addFile($filePath, pathinfo($filePath, PATHINFO_BASENAME));
            $zip->close();
        }
    }
}
