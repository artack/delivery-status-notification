<?php

declare(strict_types=1);

namespace Artack\Dsn\Field;

use Artack\Dsn\Exception\InvalidArgumentException;

class StatusField extends AbstractField
{
    private const CODE_CLASSES = [2, 4, 5];

    private $codeClass;
    private $codeSubject;
    private $codeEnumerated;

    public function __construct(string $name, int $codeClass, int $codeSubject, int $codeEnumerated, ?string $comment)
    {
        parent::__construct($name, $comment);

        $this->setCodeClass($codeClass);
        $this->setCodeSubject($codeSubject);
        $this->setCodeEnumerated($codeEnumerated);
    }

    public function getCode(): string
    {
        return sprintf('%d.%d.%d', $this->codeClass, $this->codeSubject, $this->codeEnumerated);
    }

    public function getCodeClass(): int
    {
        return $this->codeClass;
    }

    public function setCodeClass(?int $codeClass): void
    {
        if (!\in_array($codeClass, self::CODE_CLASSES, true)) {
            throw new InvalidArgumentException(sprintf('given code class "%s" is not one of "%s"', $codeClass, implode(', ', self::CODE_CLASSES)));
        }

        $this->codeClass = $codeClass;
    }

    public function getCodeSubject(): int
    {
        return $this->codeSubject;
    }

    public function setCodeSubject(int $codeSubject): void
    {
        if ($codeSubject < 0 || $codeSubject > 7) {
            throw new InvalidArgumentException(sprintf('given code class "%d" is not in the range between 0 and 7', $codeSubject));
        }

        $this->codeSubject = $codeSubject;
    }

    public function getCodeEnumerated(): int
    {
        return $this->codeEnumerated;
    }

    public function setCodeEnumerated(int $codeEnumerated): void
    {
        if ($codeEnumerated < 0 || $codeEnumerated > 999) {
            throw new InvalidArgumentException(sprintf('given code enumerated "%d" is not in the range between 0 and 999', $codeEnumerated));
        }

        $this->codeEnumerated = $codeEnumerated;
    }
}
