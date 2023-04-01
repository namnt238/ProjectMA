<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Filesystem\FilesystemAdapter;
// use Illuminate\Filesystem\FilesystemAdapter;

class GoogleDriveController extends Controller
{
    public function getFileUpload(){
        $fileMetadata = $filesystem->getMetadata($pathToFile);

        $result = Storage::disk('google_drive')->allFiles('');
        return response()->json($result);
    }

//     ->getAdapter()
// ->getMetadata('ProjectMA/BOOK SOCIAL NETWORK_1680271455.docx')
// ->extraMetadata()['id];


    public function getAllFileUpload(){
        $result = Storage::disk('google_drive')->get('1o_NRskg9rql9Y78XQURVfNIu54fT7Guq');
        return response()->make(
            $result,
            200,
            ['Content-Type' => 'image/png'],
        );
    }

    public function fileUploadToCloud(Request $request){
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
                        
            $value = $request->file('file');
            
            $result = Storage::disk('s3')->putFileAs("",$value,$filenametostore);

            // $meta = Storage::disk("google_drive")->getAdapter()->getMetadata($filenametostore)->extraMetadata()['id'];
            
            return response()->json('success');
        }            
    }

    public function fileDownLoadCloud($id){
        $result = Storage::disk('google_drive')->get($id);
        return response()->json("Success");
    }



    public function fileDeleteCloud($id){
        $test = Storage::disk('google_drive')->exists($id);
        if($test){
            Storage::disk('google_drive')->delete($id);
            return response()->json("Success");    
        }else{
            return response()->json("Failed");    
        }
    }
}
