<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoRouteModelsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routeModels:list
                            {--name=? : search by model name}
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
        $_name = $this->option('name')?:null;
        $_name = $_name == "?" ? null : $_name;

        if($_name)
        $this->comment("model: " . $_name);

        $data = collect(autoModel()->enable()->map(function($v, $k) use($_name) {
            if(!empty($_name) && !str_contains($k, $_name))
                return null;

            return [$k, $v, 'Y'];
        })->filter())->merge(autoModel()->disable()->map(function($v, $k) use($_name) {
            if(!empty($_name) && !str_contains($k, $_name))
                return null;

            return [$k, $v, 'N'];
        })->filter());

        $this->table(['Name','Class','Active'], $data->toArray());
    }
}
