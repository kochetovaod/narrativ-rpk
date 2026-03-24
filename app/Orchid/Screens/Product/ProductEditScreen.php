<?php

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Orchid\Layouts\Common\DetailTabLayout;
use App\Orchid\Layouts\Common\GalleryTabLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\PreviewTabLayout;
use App\Orchid\Layouts\Common\SeoTabLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use App\Orchid\Layouts\Product\ProductSpecificFieldsLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProductEditScreen extends Screen
{
    /**
     * @var Product
     */
    public $product;

    /**
     * Query data.
     */
    public function query(Product $product): array
    {
        // Загружаем связи
        $product->load(['attachments', 'seo', 'category', 'preview', 'detail']);

        // Если SEO не существует, создаём пустой объект
        if (! $product->seo) {
            $product->seo = $product->seo()->make();
        }

        return [
            'product' => $product,
            'seo' => $product->seo,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->product->exists
            ? 'Редактирование продукции: '.$this->product->title
            : 'Создание продукции';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление продукциями компании';
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
                ->canSee($this->product->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->product->exists)
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
                ->confirm('Вы уверены, что хотите удалить эту продукцию?')
                ->canSee($this->product->exists)
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
                    new TechnicalInfoLayout('product')
                        ->canSee($this->product->exists),

                    // Основные поля
                    new MainFieldsLayout('product', 'Название продукции'),

                    // Специфичные поля продукции
                    new ProductSpecificFieldsLayout,
                ],

                'Анонс' => [
                    new PreviewTabLayout('product', 800, 600),
                ],

                'Подробно' => [
                    new DetailTabLayout('product', 1200, 800),
                ],

                'SEO' => [
                    new SeoTabLayout,
                ],

                'Галерея' => [
                    new GalleryTabLayout('product'),
                ],
            ]),
        ];
    }

    /**
     * Сохранение или обновление продукции
     */
    public function save(Product $product, Request $request): RedirectResponse
    {
        $redirect = $request->get('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'product.title' => 'required|string|max:255',
            'product.slug' => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'product.excerpt' => 'nullable|string|max:500',
            'product.content' => 'nullable|string',
            'product.price_from' => 'nullable|numeric|min:0',
            'product.preview_id' => 'nullable|integer|exists:attachments,id',
            'product.detail_id' => 'nullable|integer|exists:attachments,id',
            'product.sort' => 'nullable|integer',
            'product.active' => 'boolean',
            'product.published_at' => 'nullable|date',
        ]);

        // Сохраняем основные данные
        $product->fill($request->get('product'))->save();

        // Синхронизируем галерею
        $product->attachments()->syncWithoutDetaching(
            $request->input('product.attachments', [])
        );

        // Сохраняем SEO данные
        $seoData = $request->get('seo', []);
        if (! empty(array_filter($seoData))) {
            $product->updateSeo($seoData);
        }

        Alert::success('Продукция успешно сохранена.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.products.edit', $product);
        }

        return redirect()->route('platform.products.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.products.list');
    }

    /**
     * Удаление продукции
     *
     * @throws \Exception
     */
    public function remove(Product $product): RedirectResponse
    {
        // Удаляем связанные вложения
        $product->preview()->delete();
        $product->detail()->delete();
        $product->attachments->each->delete();

        // Удаляем SEO
        if ($product->seo) {
            $product->seo->delete();
        }

        // Удаляем продукцию
        $product->delete();

        Alert::success('Продукция успешно удалена.');

        return redirect()->route('platform.products.list');
    }
}
