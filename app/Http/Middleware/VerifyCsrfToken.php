<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'http://127.0.0.1:8000/fileUploadToCloud/s3',
        'http://127.0.0.1:8000/deleteFile',
        'http://127.0.0.1:8000/fileUploadToCloud/google',
        'http://127.0.0.1:8000/fileUploadToCloud/dropbox',
        'http://127.0.0.1:8000/fileDeleteCloud/google/1CgKtpYVSzsrPg9topDxq1Tld01ckSc9i'
    ];
}
