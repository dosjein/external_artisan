<?php

namespace Darunada\Console;

use Illuminate\Filesystem\Filesystem;
use Pimple\Container;
use Symfony\Component\Console\Application;

class InitArtisan
{

    private $kernelClass = null;

    /**
     * InitArtisan constructor.
     * @param $kernelClass
     */
    public function __construct($kernelClass)
    {
        $this->kernelClass = $kernelClass;
    }

    /**
     * Init fake Artisan
     * @param  String $addName Artisan Display name
     * @param  String $appVersion Artisan Display version
     * @return Application
     */
    public function init($addName, $appVersion)
    {
        $kernel = new $this->kernelClass();
        $app = new Application($addName, $appVersion);

        foreach ($kernel->getCommands() as $command => $path) {
            $container = new Container();

            $container['filesystem'] = function (Container $c) {
                $filesystem = new Filesystem();
                return $filesystem;
            };

            $container['details'] = function (Container $c) use ($path) {
                $console = new $path($c);
                $console->setLaravel(new FakeLaravel($console));
                return $console;
            };

            $app->add($container['details']);
        }

        return $app;
    }
}