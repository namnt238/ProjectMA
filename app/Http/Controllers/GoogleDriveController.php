<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use App\Models\FileUpload;
// use Illuminate\Filesystem\FilesystemAdapter;
// use Illuminate\Filesystem\FilesystemAdapter;

class GoogleDriveController extends Controller
{
    public function getFileUpload(){
        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('google_drive')->listContents($dir, $recursive));

        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function getAllFileUpload(){
        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('google_drive')->listContents($dir, $recursive));

        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function fileUploadToCloud(Request $request){
        if ($request->hasFile('file')) {            
            $filenamewithextension = $request->file('file')->getClientOriginalName();
            
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
            //get file extension
            $extension = $request->file('file')->getClientOriginalExtension();
            
            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;
                        
            $value = $request->file('file');

            $size = $request->file('file')->getSize();
            
            $type = $request->file('file')->extension();

            $path = '/' . $filenametostore;
            
            $result = Storage::disk('google_drive')->putFileAs("",$value,$filenametostore);

            $url = Storage::disk('google_drive')->url($path);

            // $meta = Storage::disk("google_drive")->getAdapter()->getMetadata($filenametostore)->extraMetadata()['id']

            FileUpload::create([
                'key' => $filenametostore,
                'url' => $url,
                'size' => $size,
                'type' => $type
            ]);

            return [
                "status" => 200,
                "message" => "Success",
            ];
        }else{
            return [
                "status" => 400,
                "message" => 'Fail',
            ];
        }            
    }

    public function fileDownLoadCloud($key){
        $result = Storage::disk('google_drive')->get($key);

        return response()->make(
            $result,
            200,
            ['Content-Type' => 'image/png'],
        );
    }

    public function fileDeleteCloud($key){
        $result = Storage::disk('google_drive')->exists($key);
        if($result){
            Storage::disk('google_drive')->delete($key);
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
