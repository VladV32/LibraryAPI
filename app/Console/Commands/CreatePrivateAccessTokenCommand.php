<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Laravel\Passport\PersonalAccessTokenFactory;

class CreatePrivateAccessTokenCommand extends Command
{
    protected $signature = 'token:create {user_id}';

    protected $description = 'Create a private access token for the specified user';

    public function handle(PersonalAccessTokenFactory $tokenFactory)
    {
        $user = User::findOrFail($this->argument('user_id'));

        $tokenName = 'Private Access Token';

        $token = $tokenFactory->make($user->getKey(), $tokenName, []);

        $this->info('Token created: '.$token->accessToken);
    }
}

