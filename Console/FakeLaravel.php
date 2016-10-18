<?php namespace Darunada\Console;

use ArrayAccess;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;


class FakeLaravel implements ArrayAccess
{

    private $command;
    private $lastOutput;

    private $container = [
        'path' => APP_PATH,
        'path.base' => BASE_PATH
    ];

    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string $command
     * @param  array $parameters
     * @return int
     */
    public function call($command, array $parameters = array())
    {
        $parameters['command'] = $command;

        $this->lastOutput = new BufferedOutput;

        if (method_exists($this->command, 'fire')) {
            return $this->command->fire(new ArrayInput($parameters), $this->lastOutput);
        } else {
            if (method_exists($this->command, 'handle')) {
                return $this->command->handle(new ArrayInput($parameters), $this->lastOutput);
            } else {
                $this->command->error('missing "fire" and "handle" ');
            }
        }
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}