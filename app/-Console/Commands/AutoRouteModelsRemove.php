<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoRouteModelsRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routeModels:remove 
                            {name  : Model name to remove}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->argument('name'))
            autoModel()->forget("enable." . $this->argument('name'))->forget("disable." . $this->argument('name'));

        $this->call("routeModels:list", []);
    }
}
