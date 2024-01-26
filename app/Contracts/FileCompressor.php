<?php

namespace App\Contracts;

interface FileCompressor
{
    public function compress($filePath, $outputFormat);
}
