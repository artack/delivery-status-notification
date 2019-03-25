<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

class AbstractField implements FieldInterface
{
    private $name;
    private $comment;

    public function __construct(string $name, ?string $comment)
    {
        $this->name = $name;
        $this->comment = $comment;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
