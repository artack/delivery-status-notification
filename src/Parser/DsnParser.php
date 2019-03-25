<?php

declare(strict_types=1);

namespace Artack\Dsn\Parser;

use Artack\Dsn\DeliveryStatus;
use Artack\Dsn\Field\ActionField;
use Artack\Dsn\Field\AddressTypeField;
use Artack\Dsn\Field\DateField;
use Artack\Dsn\Field\DiagnosticTypeField;
use Artack\Dsn\Field\MtaNameTypeField;
use Artack\Dsn\Field\StatusField;
use Artack\Dsn\Field\ValueField;
use Artack\Dsn\Fields;

class DsnParser
{
    private static $map = [
//        'original-envelope-id' => null,
        'reporting-mta' => MtaNameTypeField::class,
        'dsn-gateway' => MtaNameTypeField::class,
        'received-from-mta' => MtaNameTypeField::class,
        'arrival-date' => DateField::class,
        'original-recipient' => AddressTypeField::class,
        'final-recipient' => AddressTypeField::class,
        'action' => ActionField::class,
        'status' => StatusField::class,
        'remote-mta' => MtaNameTypeField::class,
        'diagnostic-code' => DiagnosticTypeField::class,
        'last-attempt-date' => DateField::class,
//        'final-log-id' => null,
        'will-retry-until' => DateField::class,
    ];

    public function parse(string $content): DeliveryStatus
    {
        $deliveryStatus = new DeliveryStatus();

        $groups = explode("\n\n", $content);

        $messageFieldGroup = array_shift($groups);
        $deliveryStatus->setMessageFields($this->parseBlock($messageFieldGroup));

        foreach ($groups as $group) {
            $deliveryStatus->addRecipientFields($this->parseBlock($group));
        }

        return $deliveryStatus;
    }

    private function parseBlock(string $block): Fields
    {
        $blockFields = new Fields();
        $lines = explode("\n", trim($block));

        foreach ($lines as $key => $line) {
            if (false === strpos($line, ':')) {
                $lines[$key - 1] .= $line;
                unset($lines[$key]);
            }
        }

        $block = implode("\n", $lines);
        preg_match_all('/^(.*?):\s((.*?);)?(.*?)(\s\((.*)\))?$/m', $block, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = $match[1];
            $type = $match[3] ?? null;
            $value = trim($match[4]);
            $comment = $match[6] ?? null;

            $class = self::$map[strtolower($name)] ?? null;
            switch ($class) {
                case DateField::class:
                    $header = new DateField($name, new \DateTimeImmutable($value));
                    break;
                case ActionField::class:
                    $header = new ActionField($name, $value);
                    break;
                case DiagnosticTypeField::class:
                    $header = new DiagnosticTypeField($name, $value, $type, $comment);
                    break;
                case AddressTypeField::class:
                    $header = new AddressTypeField($name, $value, $type, $comment);
                    break;
                case MtaNameTypeField::class:
                    $header = new MtaNameTypeField($name, $value, $type, $comment);
                    break;
                case StatusField::class:
                    preg_match('/(\d{1}).(\d{1,3}).(\d{1,3})/', $value, $matches);
                    $header = new StatusField($name, (int) $matches[1], (int) $matches[2], (int) $matches[3], $comment);
                    break;
                default:
                    $header = new ValueField($name, $value, $comment);
            }
            $blockFields->add($header);
        }

        return $blockFields;
    }
}
