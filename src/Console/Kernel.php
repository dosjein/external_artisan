<?php namespace Shivergard\DreamApply;


class Kernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\Shivergard\DreamApply\Inspire'
    ];

    public function getCommands(){
        return $this->commands;
    }

}