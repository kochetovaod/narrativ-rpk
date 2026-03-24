<?php

// app/Enums/SettingType.php

namespace App\Enums;

use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum SettingType: string implements HasLabel
{
    use EnumHelpers;

    case STRING = 'string';
    case TEXT = 'text';
    case INTEGER = 'integer';
    case BOOLEAN = 'boolean';
    case JSON = 'json';
    case COLOR = 'color';
    case IMAGE = 'image';

    public function label(): string
    {
        return match ($this) {
            self::STRING => 'Строка',
            self::TEXT => 'Текст',
            self::INTEGER => 'Число',
            self::BOOLEAN => 'Да/Нет',
            self::JSON => 'JSON',
            self::COLOR => 'Цвет',
            self::IMAGE => 'Изображение',
        };
    }

    /**
     * Привести значение к нужному типу
     */
    public function cast(mixed $value): mixed
    {
        return match ($this) {
            self::STRING => (string) $value,
            self::TEXT => (string) $value,
            self::INTEGER => (int) $value,
            self::BOOLEAN => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            self::JSON => is_string($value) ? json_decode($value, true) : $value,
            self::COLOR => $this->validateColor((string) $value),
            self::IMAGE => (int) $value,
        };
    }

    /**
     * Подготовить значение для сохранения
     */
    public function serialize(mixed $value): string
    {
        return match ($this) {
            self::JSON => json_encode($value, JSON_UNESCAPED_UNICODE),
            self::BOOLEAN => $value ? '1' : '0',
            self::COLOR => $this->normalizeColor((string) $value),
            self::IMAGE => (string) (int) $value,
            default => (string) $value,
        };
    }

    /**
     * Получить правила валидации для этого типа
     */
    public function validationRules(): array
    {
        return match ($this) {
            self::STRING => ['string', 'max:65535'],
            self::TEXT => ['string'],
            self::INTEGER => ['integer', 'min:-2147483648', 'max:2147483647'],
            self::BOOLEAN => ['boolean'],
            self::JSON => ['json'],
            self::COLOR => ['string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$|^rgb\((\d{1,3},\s*?){2}\d{1,3}\)$|^rgba\((\d{1,3},\s*?){3}[0-1]?\.?\d*\)$/'],
            self::IMAGE => ['integer', 'exists:attachments,id'],
        };
    }

    /**
     * Получить HTML-инпут для этого типа
     */
    public function inputType(): string
    {
        return match ($this) {
            self::STRING => 'text',
            self::TEXT => 'textarea',
            self::INTEGER => 'number',
            self::BOOLEAN => 'checkbox',
            self::JSON => 'textarea',
            self::COLOR => 'color',
            self::IMAGE => 'file',
        };
    }

    /**
     * Получить дополнительные атрибуты для инпута
     */
    public function inputAttributes(): array
    {
        return match ($this) {
            self::COLOR => [
                'class' => 'w-10 h-10 p-1 rounded border cursor-pointer',
                'pattern' => '^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$',
                'title' => 'Введите HEX код цвета (например: #FF0000)',
            ],
            self::INTEGER => [
                'step' => '1',
            ],
            default => [],
        };
    }

    /**
     * Валидация цвета
     */
    private function validateColor(string $value): string
    {
        $normalized = $this->normalizeColor($value);

        // Если цвет не прошел нормализацию, возвращаем черный цвет по умолчанию
        if (! $this->isValidColor($normalized)) {
            return '#000000';
        }

        return $normalized;
    }

    /**
     * Нормализация цвета к формату HEX
     */
    private function normalizeColor(string $value): string
    {
        $value = trim($value);

        // Если пусто, возвращаем черный
        if (empty($value)) {
            return '#000000';
        }

        // Проверяем HEX (3 или 6 символов)
        if (preg_match('/^#?([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $value, $matches)) {
            $hex = ltrim($value, '#');
            // Конвертируем 3-символьный HEX в 6-символьный
            if (strlen($hex) === 3) {
                $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
            }

            return '#'.strtoupper($hex);
        }

        // TODO: Добавить поддержку RGB/RGBA если нужно
        // Здесь можно добавить конвертацию RGB в HEX

        return $value;
    }

    /**
     * Проверка валидности цвета
     */
    private function isValidColor(string $value): bool
    {
        return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value) === 1;
    }

    /**
     * Конвертировать HEX в RGB
     */
    public function hexToRgb(string $hex): ?array
    {
        $hex = $this->normalizeColor($hex);

        if (! $this->isValidColor($hex)) {
            return null;
        }

        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    /**
     * Конвертировать RGB в HEX
     */
    public function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
