<?php

use App\Http\Resources\UserResource;
use App\Models\User;

test('user can create account and interact with auth api', function () {
   $this->post(route('users.store'), [
       'name' => 'yann',
       'email' => 'email@gmail.com',
       'password' => 'password',
       'password_confirmation' => 'password',
   ])->assertCreated();

   $token = $this->post(route('login'), [
       'email' => 'email@gmail.com',
       'password' => 'password'
   ])->json('token');

   $user = User::first();

   $this->get(route('auth.index'), ['Authorization' => "Bearer $token"])
       ->assertJson(UserResource::make($user)->resolve());
});
