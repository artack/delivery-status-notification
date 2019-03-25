<?php

declare(strict_types=1);

namespace Artack\Dsn;

use Artack\Dsn\Field\FieldInterface;

class Fields
{
    private $fields = [];

    public function __construct(FieldInterface ...$fields)
    {
        foreach ($fields as $field) {
            $this->add($field);
        }
    }

    public function add(FieldInterface $field): void
    {
        $name = strtolower($field->getName());
        $this->fields[$name] = $field;
    }

    public function get(string $name): ?FieldInterface
    {
        $name = strtolower($name);
        if (!isset($this->fields[$name])) {
            return null;
        }

        return $this->fields[$name];
    }

    public function getAll(): iterable
    {
        yield from $this->fields;
    }

    public function getNames(): array
    {
        return array_keys($this->fields);
    }

    public function remove(string $name): void
    {
        unset($this->fields[strtolower($name)]);
    }
}
