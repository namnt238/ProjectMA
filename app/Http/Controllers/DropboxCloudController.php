<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FileUpload;

class DropboxCloudController extends Controller
{
    public function getFileUpload(){
        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('dropbox')->listContents($dir, $recursive));    
        return [
            "status" => 200,
            "data" => $contents
        ];
    }

    public function getAllFileUpload(){
        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('dropbox')->listContents($dir, $recursive));    
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
        
            // $result = Storage::disk('dropbox')->put($filenametostore,file_get_contents($value));

            // $url = Storage::disk('dropbox')->url($path);
            $result = Storage::disk('dropbox')->putFileAs("",$value,$filenametostore);

            $url = Storage::disk('dropbox')->url($path);

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
        $result = Storage::disk('dropbox')->get($key);

        return [
            "status" => 200,
            ['Content-Type' => 'image/png'],
            "data" => $result
        ];
    }

    public function fileDeleteCloud($key){
        $result = Storage::disk('dropbox')->exists($key);
        if($result){
            Storage::disk('dropbox')->delete($key);
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
