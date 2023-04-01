<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Google_Client;
use Google_Service_Drive;
use League\Flysystem\Filesystem;
// use Storage;
use Illuminate\Support\Facades\Storage;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google_drive', function($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $client->setScopes(array(
                'https://www.googleapis.com/auth/drive.file',
    //            'https://www.googleapis.com/auth/plus.login',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/drive.metadata',
                'https://www.googleapis.com/auth/drive',
                'https://www.googleapis.com/drive/v3/files/fileId'
            ));

            $client->addScope('email');

            $client->setAccessType("offline");
    
            $client->setApprovalPrompt("force");
    
            $service = new Google_Service_Drive($client);
 
            $options = [];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }
 
            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);
 
            return new Filesystem($adapter);
        });
    }
}
