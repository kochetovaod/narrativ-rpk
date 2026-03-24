<?php

namespace App\Orchid\Screens\ProductCategory;

use App\Models\ProductCategory;
use App\Orchid\Layouts\Common\DetailTabLayout;
use App\Orchid\Layouts\Common\GalleryTabLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\PreviewTabLayout;
use App\Orchid\Layouts\Common\SeoTabLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use App\Orchid\Layouts\ProductCategory\ProductCategorySpecificFieldsLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProductCategoryEditScreen extends Screen
{
    /**
     * @var ProductCategory
     */
    public $category;

    /**
     * Query data.
     */
    public function query(ProductCategory $category): array
    {
        // Загружаем связи
        $category->load(['attachments', 'seo', 'preview', 'detail']);

        // Если SEO не существует, создаём пустой объект
        if (! $category->seo) {
            $category->seo = $category->seo()->make();
        }

        return [
            'category' => $category,
            'seo' => $category->seo,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {

        return $this->category->exists
            ? 'Редактирование категории: '.$this->category->title
            : 'Создание категории';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление категориями продукции';
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
                ->canSee($this->category->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->category->exists)
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
                ->confirm('Вы уверены, что хотите удалить эту категорию?')
                ->canSee($this->category->exists)
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
                    new TechnicalInfoLayout('category')
                        ->canSee($this->category->exists),

                    // Основные поля
                    new MainFieldsLayout('category', 'Название категории'),

                    // Специфичные поля категории
                    new ProductCategorySpecificFieldsLayout,
                ],

                'Анонс' => [
                    new PreviewTabLayout('category', 800, 600),
                ],

                'Подробно' => [
                    new DetailTabLayout('category', 1200, 800),
                ],

                'SEO' => [
                    new SeoTabLayout,
                ],

                'Галерея' => [
                    new GalleryTabLayout('category'),
                ],
            ]),
        ];
    }

    /**
     * Сохранение или обновление категории
     */
    public function save(ProductCategory $category, Request $request): RedirectResponse
    {
        $redirect = $request->input('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'category.title' => 'required|string|max:255',
            'category.slug' => 'nullable|string|max:255|unique:product_categories,slug,'.$category->id,
            'category.excerpt' => 'nullable|string|max:500',
            'category.content' => 'nullable|string',
            'category.preview_id' => 'nullable|integer|exists:attachments,id',
            'category.detail_id' => 'nullable|integer|exists:attachments,id',
            'category.sort' => 'nullable|integer',
            'category.active' => 'boolean',
            'category.published_at' => 'nullable|date',
        ]);

        // Сохраняем основные данные
        $category->fill($request->input('category'))->save();

        // Синхронизируем галерею
        $category->attachments()->syncWithoutDetaching(
            $request->input('category.attachments', [])
        );

        // Сохраняем SEO данные
        $seoData = $request->input('seo', []);
        if (! empty(array_filter($seoData))) {
            $category->updateSeo($seoData);
        }

        Alert::success('Категория успешно сохранена.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.product-categories.edit', $category);
        }

        return redirect()->route('platform.product-categories.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.product-categories.list');
    }

    /**
     * Удаление категории
     *
     * @throws \Exception
     */
    public function remove(ProductCategory $productCategory): RedirectResponse
    {
        // Удаляем связанные вложения
        $productCategory->preview()->delete();
        $productCategory->detail()->delete();
        $productCategory->attachments->each->delete();

        // Удаляем SEO
        if ($productCategory->seo) {
            $productCategory->seo->delete();
        }

        // Удаляем категорию
        $productCategory->delete();

        Alert::success('Категория успешно удалена.');

        return redirect()->route('platform.product-categories.list');
    }
}
