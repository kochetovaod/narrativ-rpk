<?php

namespace App\Orchid\Screens\Portfolio;

use App\Models\Portfolio;
use App\Orchid\Layouts\Common\DetailTabLayout;
use App\Orchid\Layouts\Common\GalleryTabLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\PreviewTabLayout;
use App\Orchid\Layouts\Common\SeoTabLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use App\Orchid\Layouts\Portfolio\PortfolioSpecificFieldsLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PortfolioEditScreen extends Screen
{
    /**
     * @var Portfolio
     */
    public $Portfolio;

    /**
     * Query data.
     */
    public function query(Portfolio $Portfolio): array
    {
        // Загружаем связи
        $Portfolio->load(['attachments', 'seo', 'preview', 'detail', 'client', 'services', 'products']);

        // Если SEO не существует, создаём пустой объект
        if (! $Portfolio->seo) {
            $Portfolio->seo = $Portfolio->seo()->make();
        }

        return [
            'Portfolio' => $Portfolio,
            'seo' => $Portfolio->seo,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->Portfolio->exists
            ? 'Редактирование работы: '.$this->Portfolio->title
            : 'Создание работы в портфолио';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление работами в портфолио компании';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee($this->Portfolio->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->Portfolio->exists)
                ->class('btn btn-success'),

            Button::make('Применить')
                ->icon('reload')
                ->method('save')
                ->parameters(['redirect' => 'edit'])
                ->class('btn btn-primary me-2'),

            Button::make('Отмена')
                ->icon('close')
                ->method('cancel')
                ->confirm('Вы уверены? Несохранённые данные будут потеряны.')
                ->class('btn btn-secondary me-2'),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->confirm('Вы уверены, что хотите удалить эту работу?')
                ->canSee($this->Portfolio->exists)
                ->class('btn btn-danger'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs([
                'Основная информация' => [
                    // Техническая информация (только для существующих записей)
                    new TechnicalInfoLayout('Portfolio')
                        ->canSee($this->Portfolio->exists),

                    // Основные поля
                    new MainFieldsLayout('Portfolio', 'Название работы'),

                    // Специфичные поля портфолио
                    new PortfolioSpecificFieldsLayout,
                ],

                'Анонс' => [
                    new PreviewTabLayout('Portfolio', 800, 600),
                ],

                'Подробно' => [
                    new DetailTabLayout('Portfolio', 1200, 800),
                ],

                'SEO' => [
                    new SeoTabLayout,
                ],

                'Галерея' => [
                    new GalleryTabLayout('Portfolio'),
                ],
            ]),
        ];
    }

    /**
     * Сохранение или обновление работы
     */
    public function save(Portfolio $Portfolio, Request $request): RedirectResponse
    {
        $redirect = $request->input('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'Portfolio.title' => 'required|string|max:255',
            'Portfolio.slug' => 'nullable|string|max:255|unique:portfolio_works,slug,'.$Portfolio->id,
            'Portfolio.content' => 'nullable|string',
            'Portfolio.address' => 'nullable|string|max:255',
            'Portfolio.client_id' => 'nullable|integer|exists:clients,id',
            'Portfolio.preview_id' => 'nullable|integer|exists:attachments,id',
            'Portfolio.detail_id' => 'nullable|integer|exists:attachments,id',
            'Portfolio.completed_at' => 'nullable|date',
            'Portfolio.sort' => 'nullable|integer',
            'Portfolio.active' => 'boolean',
            'Portfolio.published_at' => 'nullable|date',
        ]);

        // Сохраняем основные данные
        $Portfolio->fill($request->input('Portfolio'))->save();

        // Синхронизируем услуги
        if ($request->has('Portfolio.services')) {
            $services = $request->input('Portfolio.services', []);
            $sorts = $request->input('Portfolio.services.*.pivot.sort', []);

            $pivotData = [];
            foreach ($services as $index => $serviceId) {
                $pivotData[$serviceId] = [
                    'sort' => $sorts[$index] ?? 500,
                ];
            }
            $Portfolio->services()->sync($pivotData);
        } else {
            $Portfolio->services()->sync([]);
        }

        // Синхронизируем продукцию
        if ($request->has('Portfolio.products')) {
            $products = $request->input('Portfolio.products', []);
            $sorts = $request->input('Portfolio.products.*.pivot.sort', []);

            $pivotData = [];
            foreach ($products as $index => $productId) {
                $pivotData[$productId] = [
                    'sort' => $sorts[$index] ?? 500,
                ];
            }
            $Portfolio->products()->sync($pivotData);
        } else {
            $Portfolio->products()->sync([]);
        }

        // Синхронизируем галерею
        $Portfolio->attachments()->syncWithoutDetaching(
            $request->input('Portfolio.attachments', [])
        );

        // Сохраняем SEO данные
        $seoData = $request->input('seo', []);
        if (! empty(array_filter($seoData))) {
            $Portfolio->updateSeo($seoData);
        }

        Alert::success('Работа успешно сохранена.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.portfolio.edit', $Portfolio);
        }

        return redirect()->route('platform.portfolio.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.portfolio.list');
    }

    /**
     * Удаление работы
     *
     * @throws \Exception
     */
    public function remove(Portfolio $Portfolio): RedirectResponse
    {
        // Удаляем связанные вложения
        $Portfolio->preview()->delete();
        $Portfolio->detail()->delete();
        $Portfolio->attachments->each->delete();

        // Удаляем SEO
        if ($Portfolio->seo) {
            $Portfolio->seo->delete();
        }

        // Удаляем связи
        $Portfolio->services()->detach();
        $Portfolio->products()->detach();

        // Удаляем работу
        $Portfolio->delete();

        Alert::success('Работа успешно удалена.');

        return redirect()->route('platform.portfolio.list');
    }
}
