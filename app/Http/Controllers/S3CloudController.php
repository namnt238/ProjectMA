<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3V3Adapter;
use App\Models\FileUpload;

class S3CloudController extends Controller
{
    public function getFileUpload(){
        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('s3')->listContents($dir, $recursive));    
        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function getAllFileUpload(){
        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('s3')->listContents($dir, $recursive));    
        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function fileUploadToCloud($request){
        if ($request->hasFile('file')) {
            $filenamewithextension = $request->file('file')->getClientOriginalName();
            
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
            $extension = $request->file('file')->getClientOriginalExtension();
            
            $filenametostore = $filename . '_' . time() . '.' . $extension;
                        
            $value = $request->file('file');

            $size = $request->file('file')->getSize();
            
            $type = $request->file('file')->extension();

            $path = '/' . $filenametostore;
        
            $result = Storage::disk('s3')->put($filenametostore,file_get_contents($value));

            $url = Storage::disk('s3')->url($path);

            FileUpload::create([
                'key' => $filenametostore,
                'url' => $url,
                'size' => $size,
                'type' => $type
            ]);

            return [
                "status" => 200,
                "message" => 'Success',
            ];
        }else{
            return [
                "status" => 400,
                "message" => 'Fail',
            ];
        }            
    }

    public function fileDownLoadCloud($key){
        $result = Storage::disk('s3')->get($key);

        return [
            "status" => 200,
            ['Content-Type' => 'image/png'],
            "data" => $result
        ];
    }

    public function fileDeleteCloud($key){
        $result = Storage::disk('s3')->exists($key);
        if($result){
            Storage::disk('s3')->delete($key);
            return [
                "status" => 200,
                "message" => 'Success',
            ];
        }else{
            return [
                "status" => 400,
                "message" => 'Failed',
            ];
        }
    }
}
