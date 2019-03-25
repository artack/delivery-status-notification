<?php

declare(strict_types=1);

namespace Artack\Dsn;

use Artack\Dsn\Exception\DsnException;
use Artack\Dsn\Parser\DsnParser;

/**
 * Idea: using a multipartparser to create dsn parsers per part.
 */
class DeliveryStatusNotification
{
    public static function from(string $content): DeliveryStatus
    {
        try {
            return (new DsnParser())->parse($content);
        } catch (\Exception $e) {
            throw new DsnException('Could not parse delivery status', 0, $e);
        }
    }
}
