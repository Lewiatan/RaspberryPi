<?php namespace Raspberry;

use Raspberry\Interfaces\ScriptInterface;

class Pi
{
    private static $instance;

    protected $scripts = [];

    private function __construct() {}

    public static function instance() {
        if ( ! (self::$instance instanceof Pi)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function destroy()
    {
        self::$instance = null;
    }

    public function registerScript($name, $script)
    {
        if ( ! is_string($name)) {
            throw new \InvalidArgumentException('Script name is invalid');
        }

        if (is_string($script)) {
            if (class_exists($script)) {
                $script = new $script();
            } else {
                throw new \InvalidArgumentException('Given script does not exist');
            }
        }

        if (is_object($script) && ! ($script instanceof ScriptInterface) &&  ! ($script instanceof \Closure)) {
            throw new \InvalidArgumentException('Script class has to implement Raspberry\Interfaces\ScriptInterface or be an Closure');
        }

        $this->scripts[$name] = $script;
    }

    public function getScripts()
    {
        return $this->scripts;
    }

    public function getScript($name)
    {
        if ( ! $this->isScriptRegistered($name)) {
            throw new \InvalidArgumentException(sprintf('Script %s does not exist', $name));
        }

        return $this->scripts[$name];
    }

    public function runScript($name)
    {
        $script = $this->getScript($name);

        if ($script instanceof \Closure) {
            return $script();
        }

        return $script->run();
    }

    /**
     * @param $name
     * @return bool
     */
    private function isScriptRegistered($name)
    {
        return array_key_exists($name, $this->scripts);
    }
}