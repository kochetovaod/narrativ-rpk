<?php

namespace App\Orchid\Screens\Blog;

use App\Models\Blog;
use App\Orchid\Layouts\Common\DetailTabLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\PreviewTabLayout;
use App\Orchid\Layouts\Common\SeoTabLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class BlogEditScreen extends Screen
{
    /**
     * @var Blog
     */
    public $blog;

    /**
     * Query data.
     */
    public function query(Blog $blog): array
    {
        // Загружаем связи
        $blog->load(['seo', 'preview', 'detail']);

        // Если SEO не существует, создаём пустой объект
        if (! $blog->seo) {
            $blog->seo = $blog->seo()->make();
        }

        return [
            'blog' => $blog,
            'seo' => $blog->seo,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->blog->exists
            ? 'Редактирование новости: '.$this->blog->title
            : 'Создание новости';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление новостями компании';
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
                ->canSee($this->blog->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->blog->exists)
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
                ->confirm('Вы уверены, что хотите удалить эту новость?')
                ->canSee($this->blog->exists)
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
                    new TechnicalInfoLayout('blog')
                        ->canSee($this->blog->exists),

                    // Основные поля
                    new MainFieldsLayout('blog', 'Название новости'),
                ],

                'Анонс' => [
                    new PreviewTabLayout('blog', 800, 600),
                ],

                'Подробно' => [
                    new DetailTabLayout('blog', 1200, 800),
                ],

                'SEO' => [
                    new SeoTabLayout,
                ],

                // Нет вкладки "Галерея"
            ]),
        ];
    }

    /**
     * Сохранение или обновление новости
     */
    public function save(Blog $blog, Request $request): RedirectResponse
    {
        $redirect = $request->get('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'blog.title' => 'required|string|max:255',
            'blog.slug' => 'nullable|string|max:255|unique:blogs,slug,'.$blog->id,
            'blog.excerpt' => 'nullable|string|max:500',
            'blog.content' => 'nullable|string',
            'blog.preview_id' => 'nullable|integer|exists:attachments,id',
            'blog.detail_id' => 'nullable|integer|exists:attachments,id',
            'blog.sort' => 'nullable|integer',
            'blog.active' => 'boolean',
            'blog.published_at' => 'nullable|date',
        ]);

        // Сохраняем основные данные
        $blog->fill($request->get('blog'))->save();

        // Сохраняем SEO данные
        $seoData = $request->get('seo', []);
        if (! empty(array_filter($seoData))) {
            $blog->updateSeo($seoData);
        }

        Alert::success('Новость успешно сохранена.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.blogs.edit', $blog);
        }

        return redirect()->route('platform.blogs.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.blogs.list');
    }

    /**
     * Удаление новости
     *
     * @throws \Exception
     */
    public function remove(Blog $blog): RedirectResponse
    {
        // Удаляем связанные вложения
        $blog->preview()->delete();
        $blog->detail()->delete();

        // Удаляем SEO
        if ($blog->seo) {
            $blog->seo->delete();
        }

        // Удаляем новость
        $blog->delete();

        Alert::success('Новость успешно удалена.');

        return redirect()->route('platform.blogs.list');
    }
}
