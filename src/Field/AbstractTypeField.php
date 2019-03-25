<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use Artack\Dsn\Exception\InvalidArgumentException;

abstract class AbstractTypeField extends AbstractField
{
    private $type;
    private $value;

    public function __construct(string $name, string $value, ?string $type, ?string $comment)
    {
        parent::__construct($name, $comment);

        $this->setValue($value);
        $this->setType($type);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        if (!\in_array($type, $this->getTypes(), true)) {
            throw new InvalidArgumentException(sprintf('given type "%s" is not one of "%s"', $type, implode(', ', $this->getTypes())));
        }

        $this->type = $type;
    }

    abstract protected function getTypes(): array;
}
