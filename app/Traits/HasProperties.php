<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Trait HasProperties
 *
 * Предоставляет функциональность для работы с JSON-полем properties
 * Хранит дополнительные атрибуты модели в формате ключ-значение
 */
trait HasProperties
{
    /**
     * Boot the trait
     */
    public static function bootHasProperties(): void
    {
        // При создании модели устанавливаем пустой массив по умолчанию
        static::creating(function ($model) {
            if (is_null($model->properties)) {
                $model->properties = [];
            }
        });
    }

    /**
     * Получить все свойства
     */
    public function getProperties(): array
    {
        return $this->properties ? $this->properties->toArray() : [];
    }

    /**
     * Получить значение свойства по ключу
     */
    public function getProperty(string $key, mixed $default = null): mixed
    {
        if (! $this->properties) {
            return $default;
        }

        // Поддержка точечной нотации (например, 'technical.weight')
        if (str_contains($key, '.')) {
            return data_get($this->properties, $key, $default);
        }

        return $this->properties[$key] ?? $default;
    }

    /**
     * Установить значение свойства
     */
    public function setProperty(string $key, mixed $value): self
    {
        $properties = $this->properties ? $this->properties->toArray() : [];

        // Поддержка точечной нотации
        if (str_contains($key, '.')) {
            data_set($properties, $key, $value);
        } else {
            $properties[$key] = $value;
        }

        $this->properties = $properties;

        return $this;
    }

    /**
     * Установить несколько свойств
     */
    public function setProperties(array $properties): self
    {
        $currentProperties = $this->properties ? $this->properties->toArray() : [];
        $this->properties = array_merge($currentProperties, $properties);

        return $this;
    }

    /**
     * Проверить наличие свойства
     */
    public function hasProperty(string $key): bool
    {
        if (! $this->properties) {
            return false;
        }

        if (str_contains($key, '.')) {
            return data_get($this->properties, $key) !== null;
        }

        return isset($this->properties[$key]);
    }

    /**
     * Удалить свойство
     */
    public function removeProperty(string $key): self
    {
        if (! $this->properties) {
            return $this;
        }

        $properties = $this->properties->toArray();

        if (str_contains($key, '.')) {
            data_forget($properties, $key);
        } else {
            unset($properties[$key]);
        }

        $this->properties = $properties;

        return $this;
    }

    /**
     * Удалить несколько свойств
     */
    public function removeProperties(array $keys): self
    {
        foreach ($keys as $key) {
            $this->removeProperty($key);
        }

        return $this;
    }

    /**
     * Очистить все свойства
     */
    public function clearProperties(): self
    {
        $this->properties = [];

        return $this;
    }

    /**
     * Получить все свойства в виде коллекции
     */
    public function getPropertiesCollection(): Collection
    {
        return collect($this->getProperties());
    }

    /**
     * Получить свойства, сгруппированные по префиксу
     */
    public function getPropertiesByPrefix(string $prefix): array
    {
        $result = [];
        $prefix = rtrim($prefix, '.').'.';

        foreach ($this->getProperties() as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $newKey = substr($key, strlen($prefix));
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Получить свойства, сгруппированные по категориям
     * (ожидается формат ключей вида "category.subkey")
     */
    public function getPropertiesGrouped(): array
    {
        $result = [];

        foreach ($this->getProperties() as $key => $value) {
            if (str_contains($key, '.')) {
                [$group, $subkey] = explode('.', $key, 2);
                $result[$group][$subkey] = $value;
            } else {
                $result['general'][$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Инкрементировать числовое свойство
     */
    public function incrementProperty(string $key, int $amount = 1): int
    {
        $current = (int) $this->getProperty($key, 0);
        $newValue = $current + $amount;
        $this->setProperty($key, $newValue);

        return $newValue;
    }

    /**
     * Декрементировать числовое свойство
     */
    public function decrementProperty(string $key, int $amount = 1): int
    {
        $current = (int) $this->getProperty($key, 0);
        $newValue = max(0, $current - $amount);
        $this->setProperty($key, $newValue);

        return $newValue;
    }

    /**
     * Добавить значение в массив (если свойство - массив)
     */
    public function pushToProperty(string $key, mixed $value): self
    {
        $array = $this->getProperty($key, []);

        if (! is_array($array)) {
            $array = [];
        }

        $array[] = $value;
        $this->setProperty($key, $array);

        return $this;
    }

    /**
     * Получить свойства, отфильтрованные по callback
     */
    public function filterProperties(callable $callback): array
    {
        return array_filter($this->getProperties(), $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Получить только свойства с указанными ключами
     */
    public function onlyProperties(array $keys): array
    {
        return Arr::only($this->getProperties(), $keys);
    }

    /**
     * Получить все свойства, кроме указанных
     */
    public function exceptProperties(array $keys): array
    {
        return Arr::except($this->getProperties(), $keys);
    }

    /**
     * Проверить, соответствуют ли свойства условию
     */
    public function propertiesMatch(array $criteria): bool
    {
        foreach ($criteria as $key => $value) {
            if ($this->getProperty($key) != $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * Получить значение свойства с приведением к типу
     */
    public function getPropertyAs(string $key, string $type, mixed $default = null): mixed
    {
        $value = $this->getProperty($key, $default);

        return match ($type) {
            'int', 'integer' => (int) $value,
            'float', 'double' => (float) $value,
            'bool', 'boolean' => (bool) $value,
            'string' => (string) $value,
            'array' => (array) $value,
            'json' => json_encode($value),
            default => $value,
        };
    }

    /**
     * Получить все свойства в виде JSON
     */
    public function getPropertiesJson(): string
    {
        return json_encode($this->getProperties());
    }

    /**
     * Импортировать свойства из JSON
     */
    public function importPropertiesFromJson(string $json): self
    {
        $data = json_decode($json, true);

        if (is_array($data)) {
            $this->setProperties($data);
        }

        return $this;
    }

    /**
     * Получить количество свойств
     */
    public function countProperties(): int
    {
        return count($this->getProperties());
    }

    /**
     * Проверить, пусты ли свойства
     */
    public function propertiesIsEmpty(): bool
    {
        return empty($this->getProperties());
    }

    /**
     * Получить имена всех свойств
     */
    public function getPropertyKeys(): array
    {
        return array_keys($this->getProperties());
    }

    /**
     * Получить все значения свойств
     */
    public function getPropertyValues(): array
    {
        return array_values($this->getProperties());
    }
}
