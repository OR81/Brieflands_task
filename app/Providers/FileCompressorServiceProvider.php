<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\FileCompressor;
use App\Services\ZipFileCompressor;

class FileCompressorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileCompressor::class, ZipFileCompressor::class);
    }
}
