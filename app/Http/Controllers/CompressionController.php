<?php

namespace App\Http\Controllers;

use App\Contracts\FileCompressor;
use App\Jobs\CompressFile;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class CompressionController extends Controller
{

    public function __construct(public FileCompressor $fileCompressor)
    {}

    public function compress(Request $request)
    {
        try {
            //fixme این فانکشن احراز هویت نمی شود
            $request->validate([
                'file' => 'required|file', //todo این بخش نیاز به فیلتر کردن بر حسب حجم نیز دارد
                'output_format' => ['nullable', Rule::in(Config::get('compression.available_formats'))],
            ]);

            $filePath = $request->file('file')->path();
            $outputFormat = $request->input('output_format') ?? Config::get('compression.default_format');

            // Dispatch کردن Job برای انجام فشرده‌سازی
            CompressFile::dispatch($this->fileCompressor, $filePath, $outputFormat)->onQueue('compress_queue');

            return response()->json(['message' => 'Compression job dispatched successfully']);
        } catch (PostTooLargeException $e) {
            // این خطا در فایل Exceptions/Handler قبل از رسیدن به این route نیز بررسی میشود
            //بررسی حجم فایل ها در فایل مذکور بهینه تر و ایمن تر میباشد
            return response()->json(['error' => 'حجم فایل بیش از حد مجاز است'], 422);
        }
    }
}
