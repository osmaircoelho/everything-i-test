<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Console\Command;

class ImportFromAmazonCommand extends Command
{
    protected $signature = 'app:import-from-amazon-command';

    protected $description = 'Command description';

    public function handle(CreateProductAction $action)
    {
        $data = \Http::get('https://api.amazon.com/products')->json();

        foreach ($data as $item) {
            $action->handle($item['title'], User::first());
        }
    }
}
