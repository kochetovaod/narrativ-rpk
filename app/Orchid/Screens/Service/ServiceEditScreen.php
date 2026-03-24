<?php

namespace App\Orchid\Screens\Service;

use App\Models\Service;
use App\Orchid\Layouts\Common\DetailTabLayout;
use App\Orchid\Layouts\Common\GalleryTabLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\PreviewTabLayout;
use App\Orchid\Layouts\Common\SeoTabLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use App\Orchid\Layouts\Service\ServiceSpecificFieldsLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ServiceEditScreen extends Screen
{
    /**
     * @var Service
     */
    public $service;

    /**
     * Query data.
     */
    public function query(Service $service): array
    {
        // Загружаем связи
        $service->load(['attachments', 'seo', 'preview', 'detail']);

        // Если SEO не существует, создаём пустой объект
        if (! $service->seo) {
            $service->seo = $service->seo()->make();
        }

        return [
            'service' => $service,
            'seo' => $service->seo,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->service->exists
            ? 'Редактирование услуги: '.$this->service->title
            : 'Создание услуги';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление услугами компании';
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
                ->canSee($this->service->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->service->exists)
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
                ->confirm('Вы уверены, что хотите удалить эту услугу?')
                ->canSee($this->service->exists)
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
                    new TechnicalInfoLayout('service')
                        ->canSee($this->service->exists),

                    // Основные поля
                    new MainFieldsLayout('service', 'Название услуги'),

                    // Специфичные поля услуги
                    new ServiceSpecificFieldsLayout,
                ],

                'Анонс' => [
                    new PreviewTabLayout('service', 800, 600),
                ],

                'Подробно' => [
                    new DetailTabLayout('service', 1200, 800),
                ],

                'SEO' => [
                    new SeoTabLayout,
                ],

                'Галерея' => [
                    new GalleryTabLayout('service'),
                ],
            ]),
        ];
    }

    /**
     * Сохранение или обновление услуги
     */
    public function save(Service $service, Request $request): RedirectResponse
    {
        $redirect = $request->get('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'service.title' => 'required|string|max:255',
            'service.slug' => 'nullable|string|max:255|unique:services,slug,'.$service->id,
            'service.excerpt' => 'nullable|string|max:500',
            'service.content' => 'nullable|string',
            'service.price_from' => 'nullable|numeric|min:0',
            'service.preview_id' => 'nullable|integer|exists:attachments,id',
            'service.detail_id' => 'nullable|integer|exists:attachments,id',
            'service.sort' => 'nullable|integer',
            'service.active' => 'boolean',
            'service.published_at' => 'nullable|date',
        ]);

        // Сохраняем основные данные
        $service->fill($request->get('service'))->save();

        // Синхронизируем галерею
        $service->attachments()->syncWithoutDetaching(
            $request->input('service.attachments', [])
        );

        // Сохраняем SEO данные
        $seoData = $request->get('seo', []);
        if (! empty(array_filter($seoData))) {
            $service->updateSeo($seoData);
        }

        Alert::success('Услуга успешно сохранена.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.services.edit', $service);
        }

        return redirect()->route('platform.services.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.services.list');
    }

    /**
     * Удаление услуги
     *
     * @throws \Exception
     */
    public function remove(Service $service): RedirectResponse
    {
        // Удаляем связанные вложения
        $service->preview()->delete();
        $service->detail()->delete();
        $service->attachments->each->delete();

        // Удаляем SEO
        if ($service->seo) {
            $service->seo->delete();
        }

        // Удаляем услугу
        $service->delete();

        Alert::success('Услуга успешно удалена.');

        return redirect()->route('platform.services.list');
    }
}
