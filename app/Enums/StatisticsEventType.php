<?php

// app/Enums/StatisticsEventType.php

namespace App\Enums;

use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum StatisticsEventType: string implements HasLabel
{
    use EnumHelpers;

    case PAGE_VIEW = 'page_view';
    case UNIQUE_VISIT = 'unique_visit';
    case FORM_SUBMIT = 'form_submit';
    case PHONE_CLICK = 'phone_click';

    public function label(): string
    {
        return match ($this) {
            self::PAGE_VIEW => 'Просмотр страницы',
            self::UNIQUE_VISIT => 'Уникальный визит',
            self::FORM_SUBMIT => 'Отправка формы',
            self::PHONE_CLICK => 'Клик по телефону',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PAGE_VIEW => 'blue',
            self::UNIQUE_VISIT => 'green',
            self::FORM_SUBMIT => 'orange',
            self::PHONE_CLICK => 'purple',
        };
    }
}
