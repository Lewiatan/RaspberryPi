<?php namespace Raspberry;

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

        if (is_string($script) && (! file_exists($script) && ! class_exists($script))) {
            throw new \InvalidArgumentException('Script does not exist');
        }

        if (is_object($script) && ! ($script instanceof \Closure)) {
            throw new \InvalidArgumentException('Script is not an closure.');
        }

        $this->scripts[$name] = $script;
    }

    public function getScripts()
    {
        return $this->scripts;
    }
}