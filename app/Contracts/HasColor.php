<?php

namespace App\Contracts;

interface HasColor
{
    /**
     * Получить цвет для отображения в админке (для статусов)
     */
    public function color(): string;
}
