<?php namespace Darunada\Console;


class ArtisanKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Darunada\Console\Command\Inspire::class,
        \Darunada\Console\Command\MakeCommand::class,
        \Darunada\Console\Command\ArtisanInit::class
    ];

    /**
     * @return array
     */
    public function getCommands()
    {
        $extraCommands = [];
        if (file_exists(APP_PATH . '/commands/config.php')) {
            $extraCommands = include APP_PATH . '/commands/config.php';
        }

        return array_unique(array_merge($this->commands, $extraCommands));
    }
}