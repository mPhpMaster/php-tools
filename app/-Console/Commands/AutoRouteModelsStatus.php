<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoRouteModelsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routeModels:status 
                            {name  : Model name}
                            {active=true  : is active ? true | false}';

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
        if(trim($this->argument('active')) == "false")
            autoModel()->disable($this->argument('name'));
        else
            autoModel()->enable($this->argument('name'));


        $this->call("routeModels:list", ['--name'=>$this->argument('name')]);
    }
}
