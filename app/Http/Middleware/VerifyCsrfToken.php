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
        "/vendor/login","user/login","write-a-review", "user/submit-enquiry","add-to-wishlist","add-subscriber","/admin/login","admin/vendor-login"
    ];
}
