<?php namespace Raspberry;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use MrRio\ShellWrap;

class GPIO
{
    const IN = 'in';
    const OUT = 'out';

    const LOW = 0;
    const HI = 1;

    protected $availableModes = [self::IN, self::OUT];
    protected $availableStates = [self::LOW, self::HI];

    public function __construct(ShellWrap $shell = null) {
        if ($shell === null) {
            $shell = new ShellWrap();
        }

        $this->shell = $shell;
    }

    public function setMode($pin, $mode)
    {
        $this->checkPin($pin);
        $this->checkMode($mode);

        $this->shell->gpio([
            'g' => true
        ], sprintf('mode %d %s', $pin, $mode));

        return $this;
    }

    public function setState($pin, $state)
    {
        $this->checkPin($pin);
        $this->checkState($state);

        $this->shell->gpio([
            'g' => true
        ], sprintf('write %d %s', $pin, $state));

        return $this;
    }

    public function readState($pin)
    {
        $this->checkPin($pin);

        return $this->shell->gpio([
            'g' => true
        ], sprintf('read %d', $pin));
    }

    protected function checkMode($mode)
    {
        if ( ! in_array($mode, $this->availableModes, true)) {
            throw new \InvalidArgumentException('Wrong mode provided');
        }

        return true;
    }

    protected function checkState($state)
    {
        if ( ! in_array($state, $this->availableStates, true)) {
            throw new \InvalidArgumentException('Wrong state provided');
        }

        return true;
    }

    protected function checkPin($pin)
    {
        if ( ! is_int($pin)) {
            throw new \InvalidArgumentException('Pin number must be an integer');
        }

    }

}