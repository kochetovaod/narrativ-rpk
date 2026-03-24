<?php

namespace App\Orchid\Screens\ProductCategory;

use App\Models\ProductCategory;
use App\Orchid\Layouts\ProductCategory\ProductCategoryListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProductCategoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'productCategories' => ProductCategory::filters()
                ->defaultSort('sort', 'asc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Категории продукции';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление категориями продукции';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить категорию')
                ->icon('bs.plus-circle')
                ->route('platform.product-categories.create'),
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
            ProductCategoryListLayout::class,
        ];
    }

    /**
     * Удаление категории
     */
    public function remove(Request $request): void
    {
        ProductCategory::findOrFail($request->get('id'))->delete();

        Toast::info('Категория успешно удалена');
    }

    /**
     * Обновление сортировки через AJAX
     */
    public function updateSort(ProductCategory $category, Request $request)
    {
        $request->validate([
            'sort' => 'required|integer',
        ]);

        $category->sort = $request->input('sort');
        $category->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Порядок обновлен',
            ]);
        }

        Toast::info('Порядок обновлен');

        return back();
    }

    /**
     * Права доступа
     */
    public function permission(): ?array
    {
        return [
            'platform.product-categories.view',
        ];
    }
}
