<?php

declare(strict_types=1);

use App\Models\User;

Route::redirect('/admin/login', '/');

Route::get('/', function () {
    Auth::login(User::first());

    return redirect('/admin');
});
