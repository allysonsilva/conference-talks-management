<?php

namespace ConferenceDomain\Console\Commands;

use Illuminate\Console\Command as BaseConsoleCommand;

class FooBarCommand extends BaseConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foo:bar';

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
        $this->info("Command foo:bar");
    }
}
