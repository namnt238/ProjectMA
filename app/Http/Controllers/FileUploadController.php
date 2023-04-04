<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function getFileUpload($option,$key){
        if ($option ==='s3'){
            $s3 = new S3CloudController();
            return $s3->getFileUpload($key);
        }elseif ($option =='google'){
            $google = new GoogleDriveController();
            return $google->getFileUpload($key);
        }elseif ($option =='dropbox'){
            $google = new DropboxCloudController();
            return $google->getFileUpload($key);
        }else{
            return response()->json("{$option}");
        }
    }

    public function getAllFileUpload($option){
        if ($option ==='s3'){
            $s3 = new S3CloudController();
            return $s3->getAllFileUpload();
        }elseif ($option =='google'){
            $google = new GoogleDriveController();
            return $google->getAllFileUpload();
        }elseif ($option =='dropbox'){
            $google = new DropboxCloudController();
            return $google->getAllFileUpload();
        }else{
            return response()->json("{$option}");
        }
    }

    public function fileUploadToCloud($option,Request $request){
        if ($option =='s3'){
            $s3 = new S3CloudController();
            return $s3->fileUploadToCloud($request);
        }elseif($option =='google'){
            $google = new GoogleDriveController();
            return $google->fileUploadToCloud($request);
        }elseif($option =='dropbox'){
            $google = new DropboxCloudController();
            return $google->fileUploadToCloud($request);
        }else{
            return response()->json("{$option}");
        }
    }

    public function fileDownLoadCloud($option,$key){
        if ($option =='s3'){
            $s3 = new S3CloudController();
            return $s3->fileDownLoadCloud($key);
        }elseif($option =='google'){
            $google = new GoogleDriveController();
            return $google->fileDownLoadCloud($key);
        }elseif($option =='dropbox'){
            $google = new DropboxCloudController();
            return $google->fileDownLoadCloud($key);
        }else{
            return response()->json("{$option}");
        }
    }

    public function fileDeleteCloud($option,$key){
        if ($option =='s3'){
            $s3 = new S3CloudController();
            return $s3->fileDeleteCloud($key);
        }elseif($option =='google'){
            $google = new DropboxCloudController();
            return $google->fileDeleteCloud($key);
        }else{
            return response()->json("{$option}");
        }
    }
}
