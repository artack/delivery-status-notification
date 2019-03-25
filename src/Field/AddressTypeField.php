<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

class AddressTypeField extends AbstractTypeField
{
    protected function getTypes(): array
    {
        return [
            'rfc822',
            'x400',
            'UTF-8',
        ];
    }
}
