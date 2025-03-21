<?php

namespace App\Http;

use App\Http\Middleware\AutoSetCountryLanguageCurrency;
use App\Http\Middleware\EmailVerifiedMiddleware;
use App\Http\Middleware\HasPlanMiddleware;
use App\Http\Middleware\UserActiveMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => EmailVerifiedMiddleware::class,
        'user_active' => UserActiveMiddleware::class,
        'set_lang' => \Modules\Language\Http\Middleware\SetLangMiddleware::class,
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        'candidate' => \App\Http\Middleware\CandidateMiddleware::class,
        'company' => \App\Http\Middleware\CompanyMiddleware::class,
        'company.profile' => \App\Http\Middleware\CompanyProfileCompletion::class,
        'check_mode' => \App\Http\Middleware\CheckForAppMode::class,
        'access_limitation' => \App\Http\Middleware\AccessLimitation::class,
        'auto_set_country_language_currency' => AutoSetCountryLanguageCurrency::class,
//        'has_plan' => HasPlanMiddleware::class,

        'api_company' => \App\Http\Middleware\Api\CompanyApiMiddleware::class,
//        'api_has_plan' => \App\Http\Middleware\Api\HasPlanApiMiddleware::class,
    ];
}
