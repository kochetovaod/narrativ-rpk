<?php

namespace App\Orchid\Layouts\Settings;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

abstract class AbstractSettingsLayout extends Rows
{
    /**
     * Наследник возвращает список настроек
     */
    abstract protected function settingFields(): array;

    /**
     * Orchid вызывает этот метод
     */
    protected function fields(): iterable
    {
        $fields = [];

        foreach ($this->settingFields() as $key => $type) {
            $fieldName = "settings.$key";
            $currentValue = $this->query->get('settings.'.$key);
            switch ($type) {
                case 'text':
                case 'string': // Добавляем обработку 'string'
                    $fields[] = TextArea::make($fieldName)
                        ->title($this->label($key))
                        ->rows(3)
                        ->value($this->getStringValue($currentValue));
                    break;

                case 'boolean':
                    $fields[] = CheckBox::make($fieldName)
                        ->title($this->label($key))
                        ->sendTrueOrFalse()
                        ->value($this->getBooleanValue($currentValue));
                    break;

                case 'select':
                    $fields[] = Select::make($fieldName)
                        ->title($this->label($key))
                        ->options($this->options($key))
                        ->value($this->getStringValue($currentValue));
                    break;

                case 'color':
                    $fields[] = Input::make($fieldName)
                        ->title($this->label($key))
                        ->value($this->getStringValue($currentValue))
                        ->type('color')
                        ->style('width: 50px; height: 50px; padding: 5px;');
                    break;

                case 'image':
                    $fields[] = Cropper::make($fieldName)
                        ->title($this->label($key))
                        ->targetId()
                        ->width(500)
                        ->height(500)
                        ->value($currentValue);
                    break;

                default:

                    $fields[] = Input::make($fieldName)
                        ->title($this->label($key))
                        ->value($this->getStringValue($currentValue));
            }
        }

        return $fields;
    }

    /**
     * Извлечь ID изображения из разных форматов
     */
    protected function extractImageId($value): ?int
    {
        if (is_null($value)) {
            return null;
        }

        // Если это массив с данными изображения
        if (is_array($value)) {
            return isset($value['id']) ? (int) $value['id'] : null;
        }

        // Если это объект Attachment
        if (is_object($value) && isset($value->id)) {
            return (int) $value->id;
        }

        // Если это просто число
        if (is_numeric($value)) {
            return (int) $value;
        }

        return null;
    }

    protected function label(string $key): string
    {
        return ucfirst(str_replace('_', ' ', $key));
    }

    protected function options(string $key): array
    {
        return [];
    }

    protected function getStringValue($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if (is_object($value) && method_exists($value, 'typed_value')) {
            $typedValue = $value->typed_value;

            return is_string($typedValue) ? $typedValue : (string) $typedValue;
        }

        if (is_array($value) && isset($value['value'])) {
            return (string) $value['value'];
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return null;
    }

    /**
     * Получить булево значение
     */
    protected function getBooleanValue($value): bool
    {
        if (is_null($value)) {
            return false;
        }

        if (is_object($value) && method_exists($value, 'typed_value')) {
            return (bool) $value->typed_value;
        }

        if (is_array($value) && isset($value['value'])) {
            return filter_var($value['value'], FILTER_VALIDATE_BOOLEAN);
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
