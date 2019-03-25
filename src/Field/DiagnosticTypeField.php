<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

class DiagnosticTypeField extends AbstractTypeField
{
    protected function getTypes(): array
    {
        return [
            'smtp',
        ];
    }
}
