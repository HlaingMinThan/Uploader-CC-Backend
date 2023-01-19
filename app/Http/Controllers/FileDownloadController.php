<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function __invoke($uuid)
    {
        $file = File::whereUuid($uuid)->whereHas('links', function ($query) {
            $query->where('token', request('token'));
        })->firstOrFail();

        return (new FileResource($file))->additional([
            'meta' => [
                'download_url' => Storage::disk('s3')->temporaryUrl($file->path, now()->addHours(2), [
                    'ResponseContentType' => 'application/octet-stream', //html,txt,...
                    'ResponseContentDisposition' => 'attachment;filename=' . $file->name
                ])
            ]
        ]);
    }
}
