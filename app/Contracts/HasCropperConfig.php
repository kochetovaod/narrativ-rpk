<?php

namespace App\Contracts;

interface HasCropperConfig
{
    public static function getPreviewConfig(): array;

    public static function getDetailConfig(): array;
}
