<?php

namespace App\Contracts;

interface HasLabel
{
    /**
     * Получить человекочитаемое название для enum case
     */
    public function label(): string;
}
