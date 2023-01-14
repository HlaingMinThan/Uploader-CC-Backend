<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Models\File;
use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    public function index()
    {
        return FileResource::collection(auth()->user()->files()->latest()->get());
    }

    public function signed()
    {
        $filename = md5(request('name') . microtime()) . '.' . request('extension'); //asfasdfasf.jpg
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => config('filesystems.disks.s3.region'),
            'credentials' => [
                'key'    =>  config('filesystems.disks.s3.key'),
                'secret' =>  config('filesystems.disks.s3.secret'),
            ],
        ]);
        $postObject = new PostObjectV4(
            $s3Client,
            config('filesystems.disks.s3.bucket'),
            ['key' => 'files/' . $filename],
            [
                ['bucket' => config('filesystems.disks.s3.bucket')],
                ['starts-with', '$key', 'files/']
            ]
        );

        return [
            'attributes' => $postObject->getFormAttributes(),
            'form_input' => $postObject->getFormInputs(),
        ];
    }

    public function store()
    {
        request()->validate([
            'path' => Rule::unique('files', 'path')
        ]);
        return FileResource::make(auth()->user()->files()->firstOrCreate([
            'name' => request('name'),
            'size' => request('size'),
            'path' => request('path'),
        ]));
    }

    public function destroy(File $file)
    {
        $this->authorize('delete', $file);
        return $file->delete();
    }
}
