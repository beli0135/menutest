<?php


namespace App\Enums;

enum ActionEnum: string
{
    case AE_SEEDED = 'seeded';
    case AE_MAILED = 'mailed';
    case AE_EMPTY = '';

    public function label(): string {
        return ActionEnum::getLabel($this);
    }

    public static function getLabel(self $value): string {
        return match ($value) {
            ActionEnum::AE_SEEDED => 'seeded',
            ActionEnum::AE_MAILED => 'mailed',
            ActionEnum::AE_EMPTY => '',
        };
    }
}
