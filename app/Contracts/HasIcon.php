<?php

namespace App\Contracts;

interface HasIcon
{
    /**
     * Получить иконку для отображения в интерфейсе
     */
    public function icon(): string;
}
