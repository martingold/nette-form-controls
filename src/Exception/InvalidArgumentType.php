<?php declare(strict_types=1);

namespace MartinGold\Forms\Exception;

class InvalidArgumentType extends \Exception {

    /**
     * @var string
     */
    private $desired;

    /**
     * @var mixed
     */
    private $actual;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $param;

    /**
     * @param mixed $actual
     */
    public function __construct(string $desired, $actual, string $method, string $param) {
        $this->desired = $desired;
        $this->actual = $actual;
        $this->method = $method;
        $this->param = $param;
    }

    public function __toString() {
        return sprintf(
            '%s requires parameter $%s to be %s, %s passed instead.',
            $this->method,
            $this->param,
            $this->desired,
            is_object($this->actual) ? get_class($this->actual) : gettype($this->actual)
        );
    }

}