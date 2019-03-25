<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

class MtaNameTypeField extends AbstractTypeField
{
    protected function getTypes(): array
    {
        return [
            'dns',
            'x400',
        ];
    }
}
