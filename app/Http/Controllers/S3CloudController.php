<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class S3CloudController extends Controller
{
    public function getFileUpload(){
        
    }

    public function getAllFileUpload(){
        $result = Storage::disk('s3')->allFiles('');
        return response()->json($result);
    }

    public function fileUploadToCloud($request){
        if ($request->hasFile('file')) {
            //            $file = $request->file;
            //            $fileName = $file->getClientOriginalName();
            //            $path = $file->getRealPath();
            
                        $filenamewithextension = $request->file('file')->getClientOriginalName();
            
                        //get filename without extension
                        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
                        //get file extension
                        $extension = $request->file('file')->getClientOriginalExtension();
            
                        //filename to store
                        $filenametostore = $filename . '_' . time() . '.' . $extension;
            
                        // $size = $request->file('file')->getSize();
            
                        // $type = $request->file('file')->extension();
            
                        $value = $request->file('file');
            
                        // $url = "https://git-poly-backup.s3.ap-southeast-1.amazonaws.com/{$filenametostore}";
        
                        $result = Storage::disk('s3')->putFileAs("",$value, $filenametostore);
            
                        return response()->json("Success");
                    }else{
                        return response()->json("No");
                    }            
    }

    public function fileDownLoadCloud($key){
        return response()->make(
            Storage::disk('s3')->get($key),
            200,
            ['Content-Type' => 'image/png'],
        );
    }

    public function fileDeleteCloud($key){
        $test = Storage::disk('s3')->exists($key);
        if($test){
            Storage::disk('s3')->delete($key);
            return response()->json("Success");    
        }else{
            return response()->json("Failed");
        }
    }
}
