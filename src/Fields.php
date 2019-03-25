<?php

declare(strict_types=1);

namespace Artack\Dsn;

use Artack\Dsn\Field\FieldInterface;

class Fields
{
    private $headers = [];

    public function __construct(FieldInterface ...$headers)
    {
        foreach ($headers as $header) {
            $this->add($header);
        }
    }

    public function add(FieldInterface $header): void
    {
        $name = strtolower($header->getName());
        $this->headers[$name][] = $header;
    }
}
