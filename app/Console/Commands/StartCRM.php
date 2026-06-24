<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartCRM extends Command
{
    protected $signature = 'crm:start';

    protected $description = 'Start CRM Services';

    public function handle()
    {
        exec('start cmd /k "php artisan schedule:work"');

        exec('start cmd /k "php artisan queue:work"');

        $this->info('CRM Services Started Successfully');
    }
}