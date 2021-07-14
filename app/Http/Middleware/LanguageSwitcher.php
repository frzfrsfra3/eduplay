<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Log;
use Illuminate\Support\Facades\Storage;

class LanguageSwitcher extends Middleware
{

public function handle ($request, Closure $next)
{

   // App::setlocale(session ::has('local')? session::get('local'):config::get('app.locale'));
  App::setlocale(Session::has('local') ? Session::get('local'):config::get('app.locale') );


    return $next ($request);
}
}
