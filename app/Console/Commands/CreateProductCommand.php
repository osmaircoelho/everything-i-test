<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\{User};
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    protected $signature = 'app:create-product-command {title?} {user?}';

    protected $description = 'Command description';

    public function handle(CreateProductAction $action): void
    {
        $title = $this->argument('title');
        $user  = $this->argument('user');

        if(!$user) {
            $user = $this->components->ask('Please, provide a valid user id ');
        }

        if(!$title) {
            $title = $this->components->ask('Please, provide a title for the product ');
        }

        $action->handle(
            $title,
            User::findOrFail($user)
        );

        $this->components->info('Product created!!');
    }
}
