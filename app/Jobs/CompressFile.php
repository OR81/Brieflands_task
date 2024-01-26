<?php

namespace App\Jobs;

use App\Contracts\FileCompressor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompressFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public FileCompressor $fileCompressor, public $filePath, public $outputFormat)
    {
    }

    public function handle(): void
    {
        $this->fileCompressor->compress($this->filePath, $this->outputFormat);
    }
}
