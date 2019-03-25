<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

class ValueField extends AbstractField
{
    private $value;

    public function __construct(string $name, string $value, ?string $comment)
    {
        parent::__construct($name, $comment);

        $this->setValue($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
