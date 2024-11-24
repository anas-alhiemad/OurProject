<?php

namespace App\Aspects;

// use Go\Lang\Annotation\Aspect;
use Go\Lang\Annotation\Before;
use Go\Aop\Intercept\Joinpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Go\Aop\Aspect;

/**
 * @Aspect
 */
class FileUploadAspect implements Aspect
{
    /**
     * @Before("execution(public App\Http\Controllers\FileController->upload(..))")
     */

    // public function beforeUpload(Joinpoint $joinPoint)
    // {
    //     Log::info('FileUploadAspect triggered');
    //     $args = $joinPoint->getArguments();
    //     $request = $args[0];

    //     if ($request instanceof Request) {
    //         Log::info('FileUploadAspect triggered');
    //         $request->validate([
    //             'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
    //         ]);

    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $path = $file->store('uploads');
    //             Log::info('File uploaded to: ' . $path);
    //         } else {
    //             throw new \Exception('No file found in the request.');
    //         }
    //     }
    // }
}
