<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use Artack\Dsn\Exception\InvalidArgumentException;

class ActionField extends AbstractField
{
    private const ACTIONS = [
        'failed',
        'delayed',
        'delivered',
        'relayed',
        'expanded',
    ];
    private $action;

    public function __construct(string $name, string $action)
    {
        parent::__construct($name, null);

        $this->setAction($action);
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        if (!\in_array($action, self::ACTIONS, true)) {
            throw new InvalidArgumentException(sprintf('given action "%s" is not one of "%s"', $action, implode(', ', self::ACTIONS)));
        }

        $this->action = $action;
    }
}
