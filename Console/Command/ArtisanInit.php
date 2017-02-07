<?php

namespace Darunada\Console\Command;

/**
 * This is the CommandMakeCommand from Laravel
 * I made a slight modification to default the namespace
 */

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Pimple\Container;

class ArtisanInit extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'artisan:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create the Artisan commands folder";

    /**
     * @var Filesystem
     */
    private $files;

    /**
     * Create a new command creator command.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct();

        $this->files = $container['filesystem'];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // create the directory
        $commandsPath = $this->laravel['path'] . '/commands';
        if(!$this->files->isDirectory($commandsPath)) {
            $this->files->makeDirectory($commandsPath);
            $this->comment('Commands folder created');
        }

        // put in a stub config file
        if (!$this->files->exists($commandsPath . '/config.php')) {
            $this->files->copy(__DIR__ . '/stubs/config.php', $commandsPath . '/config.php');
            $this->comment('Config file written');
            $this->info('Artisan Initialized Successfully.');
        } else {
            $this->error('Artisan init has already been completed!');
        }
    }
}
