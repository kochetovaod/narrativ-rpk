<?php

namespace App\Orchid\Screens\Seo;

use App\Models\SEO as Seo;
use App\Orchid\Layouts\Seo\SeoListLayout;
use Orchid\Screen\Screen;

class SeoListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'seoRecords' => Seo::filters()
                ->with(['seoable'])
                ->defaultSort('id', 'asc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'SEO данные';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление SEO-данными всех сущностей сайта';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            // Фильтр по типам сущностей можно добавить через query params
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SeoListLayout::class,
        ];
    }

    /**
     * Права доступа
     */
    public function permission(): ?array
    {
        return [
            'platform.settings.manage',
        ];
    }
}
