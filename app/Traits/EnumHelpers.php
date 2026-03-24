<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait EnumHelpers
{
    /**
     * Получить все значения enum
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Получить все названия case'ов
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Получить ассоциативный массив [value => label]
     */
    public static function options(): array
    {
        $cases = self::cases();
        $options = [];

        foreach ($cases as $case) {
            $label = method_exists($case, 'label')
                ? $case->label()
                : $case->name;

            $options[$case->value ?? $case->name] = $label;
        }

        return $options;
    }

    /**
     * Получить коллекцию case'ов
     */
    public static function collect(): Collection
    {
        return collect(self::cases());
    }

    /**
     * Проверить, является ли значение валидным для enum
     */
    public static function isValid(string|int $value): bool
    {
        return in_array($value, self::values(), true);
    }

    /**
     * Попытаться создать из значения, вернуть null если невалидно
     */
    public static function tryFromSafe(string|int $value): ?static
    {
        try {
            return self::tryFrom($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Получить случайный case
     */
    public static function random(): static
    {
        $cases = self::cases();

        return $cases[array_rand($cases)];
    }
}
