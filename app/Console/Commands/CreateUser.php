<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    protected $signature = 'user:create {name?} {email?} {password?}';

    protected $description = 'Create a new user';

    public function handle()
    {
        $userData = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ];

        $validator = Validator::make($userData, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return;
        }

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
        ]);

        $this->info('User created successfully!');
        $this->info('User_id: ' . $user->id);
        $this->info('Name: ' . $user->name);
        $this->info('Email: ' . $user->email);
    }
}
