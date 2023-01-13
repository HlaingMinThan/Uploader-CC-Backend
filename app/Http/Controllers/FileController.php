<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return FileResource::collection(auth()->user()->files);
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
}
