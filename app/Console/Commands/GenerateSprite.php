<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class GenerateSprite extends Command
{
    protected $signature = 'icons:generate-sprite 
                            {--path= : Путь к папке с SVG файлами}
                            {--output= : Путь для сохранения спрайта}
                            {--clean : Очистить SVG от лишних атрибутов и тегов}';

    protected $description = 'Генерирует SVG спрайт из всех SVG файлов в указанной папке';

    protected string $sourcePath;

    protected string $outputPath;

    public function handle()
    {
        $this->setupPaths();

        if (! File::exists($this->sourcePath)) {
            $this->error("Папка с иконками не найдена: {$this->sourcePath}");

            return 1;
        }

        $svgFiles = $this->getSvgFiles();

        if (empty($svgFiles)) {
            $this->warn("В папке {$this->sourcePath} не найдено SVG файлов");

            return 0;
        }

        $this->info('Найдено SVG файлов: '.count($svgFiles));

        $sprite = $this->generateSprite($svgFiles);
        $this->saveSprite($sprite);

        $this->info("✅ SVG спрайт успешно создан: {$this->outputPath}");

        return 0;
    }

    protected function setupPaths(): void
    {
        $this->sourcePath = $this->option('path')
            ?: storage_path('app/public/seed/icons');

        $this->outputPath = $this->option('output')
            ?: resource_path('views/partials/svg-sprite.blade.php');
    }

    protected function getSvgFiles(): array
    {
        $files = File::allFiles($this->sourcePath);

        return array_filter($files, function (SplFileInfo $file) {
            return $file->getExtension() === 'svg';
        });
    }

    protected function generateSprite(array $svgFiles): string
    {
        $symbols = [];

        foreach ($svgFiles as $file) {
            $iconName = $this->getIconName($file);
            $svgContent = File::get($file->getPathname());

            // Очищаем SVG от лишних данных
            $cleanSvg = $this->cleanSvgContent($svgContent, $iconName);

            // Извлекаем viewBox
            $viewBox = $this->extractViewBox($cleanSvg);

            // Извлекаем содержимое без внешнего тега svg
            $innerContent = $this->extractInnerContent($cleanSvg);

            // Создаем символ
            $symbol = $this->createSymbol($iconName, $viewBox, $innerContent);
            $symbols[] = $symbol;

            $this->line("  Добавлена иконка: {$iconName}");
        }

        return $this->buildSpriteHtml($symbols);
    }

    protected function getIconName(SplFileInfo $file): string
    {
        return str_replace('.svg', '', $file->getFilename());
    }

    /**
     * Очищает SVG от лишних данных
     */
    protected function cleanSvgContent(string $content, string $iconName): string
    {
        // Удаляем XML декларацию
        $content = preg_replace('/<\?xml.*?\?>/', '', $content);

        // Удаляем DOCTYPE
        $content = preg_replace('/<!DOCTYPE[^>]*>/', '', $content);

        // Удаляем комментарии
        $content = preg_replace('/<!--.*?-->/s', '', $content);

        // Удаляем все теги с namespace sodipodi и inkscape
        $content = preg_replace('/<\/?(sodipodi|inkscape):[^>]*>/', '', $content);

        // Удаляем атрибуты с namespace
        $content = preg_replace('/\s+(sodipodi|inkscape):[a-zA-Z0-9_:.-]+="[^"]*"/', '', $content);

        // Удаляем служебные атрибуты
        $removeAttributes = [
            'id',
            'data-name',
            'class',
            'style',
            'xml:space',
            'xmlns:sodipodi',
            'xmlns:inkscape',
            'xmlns:xlink',
            'xmlns:svg',
            'version',
            'baseProfile',
        ];

        foreach ($removeAttributes as $attr) {
            $content = preg_replace('/\s+'.preg_quote($attr, '/').'="[^"]*"/', '', $content);
        }

        // Удаляем пустые теги defs
        $content = preg_replace('/<defs>\s*<\/defs>/', '', $content);

        // Удаляем лишние переносы строк и пробелы
        $content = preg_replace('/>\s+</', '><', $content);
        $content = trim($content);

        return $content;
    }

    /**
     * Извлекает viewBox из SVG
     */
    protected function extractViewBox(string $content): string
    {
        if (preg_match('/viewBox=["\']([^"\']*)["\']/', $content, $matches)) {
            return $matches[1];
        }

        // Если viewBox не найден, пытаемся создать из width/height
        if (preg_match('/width=["\'](\d+)["\']/', $content, $width) &&
            preg_match('/height=["\'](\d+)["\']/', $content, $height)) {
            return "0 0 {$width[1]} {$height[1]}";
        }

        return '0 0 24 24'; // Значение по умолчанию
    }

    /**
     * Извлекает внутреннее содержимое SVG (без тега <svg>)
     */
    protected function extractInnerContent(string $content): string
    {
        // Пытаемся найти содержимое между тегами svg
        if (preg_match('/<svg[^>]*>(.*?)<\/svg>/s', $content, $matches)) {
            $inner = $matches[1];
        } else {
            $inner = $content;
        }

        // Очищаем от возможных оставшихся namespace
        $inner = preg_replace('/xmlns[^=]*="[^"]*"/', '', $inner);

        // Удаляем дублирующиеся fill атрибуты, оставляем только если они не black/#000000
        $inner = preg_replace('/\s+fill="#?0{3,6}"?/', '', $inner);
        $inner = preg_replace('/\s+fill="black"/', '', $inner);

        return trim($inner);
    }

    /**
     * Создает символ для спрайта
     */
    protected function createSymbol(string $name, string $viewBox, string $content): string
    {
        // Добавляем fill="currentColor" к путям, если у них нет fill атрибута
        $content = preg_replace_callback('/<([a-zA-Z]+)([^>]*)>/', function ($matches) {
            $tag = $matches[1];
            $attributes = $matches[2];

            // Пропускаем если это не path, circle, rect, polygon, polyline
            if (! in_array($tag, ['path', 'circle', 'rect', 'polygon', 'polyline', 'g'])) {
                return $matches[0];
            }

            // Если уже есть fill, оставляем как есть
            if (preg_match('/\sfill=/', $attributes)) {
                return $matches[0];
            }

            // Добавляем fill="currentColor"
            return "<{$tag} fill=\"currentColor\"{$attributes}>";
        }, $content);

        // Формируем символ
        return sprintf(
            '<symbol id="icon-%s" viewBox="%s" fill="none">%s</symbol>',
            $name,
            $viewBox,
            $this->optimizeSvg($content)
        );
    }

    /**
     * Собирает итоговый HTML спрайта
     */
    protected function buildSpriteHtml(array $symbols): string
    {
        $symbolsHtml = implode("\n    ", $symbols);

        return <<<HTML
<svg style="display: none;" xmlns="http://www.w3.org/2000/svg">
    {$symbolsHtml}
</svg>
HTML;
    }

    protected function saveSprite(string $sprite): void
    {
        $directory = dirname($this->outputPath);

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($this->outputPath, $sprite);
    }

    protected function optimizeSvg(string $content): string
    {
        // 1. Удаляем лишние пробелы и переносы
        $content = preg_replace('/\s+/', ' ', $content);
        $content = str_replace('> <', '><', $content);

        // 2. Округляем десятичные значения в path
        $content = preg_replace_callback(
            '/([0-9]+\.[0-9]{4,})/',
            function ($matches) {
                return round((float) $matches[0], 2);
            },
            $content
        );

        // 3. Удаляем комментарии
        $content = preg_replace('/<!--.*?-->/', '', $content);

        return trim($content);
    }
}
