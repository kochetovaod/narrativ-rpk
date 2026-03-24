<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CollectFilesToMarkdown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:markdown 
                            {folder : Папка для сканирования (относительно base_path)} 
                            {--output= : Имя выходного файла (по умолчанию folder.md)}
                            {--ext=* : Фильтр по расширениям (можно указать несколько)}
                            {--ignore=* : Паттерны для игнорирования}
                            {--recursive : Рекурсивный обход папок}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Собирает все файлы из папки в один Markdown файл для работы с нейросетями';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = $this->argument('folder');
        $fullPath = base_path($folder);

        if (! File::exists($fullPath)) {
            $this->error("Папка не существует: {$fullPath}");

            return 1;
        }

        $outputName = $this->option('output') ?? str_replace('/', '_', $folder).'.md';
        $outputPath = base_path($outputName);

        $extensions = $this->option('ext');
        $ignorePatterns = $this->option('ignore');
        $recursive = $this->option('recursive');

        $this->info("Сканируем папку: {$fullPath}");
        $this->newLine();

        $files = $this->getFiles($fullPath, $extensions, $ignorePatterns, $recursive);

        if (empty($files)) {
            $this->warn('Файлы не найдены');

            return 0;
        }

        $this->info('Найдено файлов: '.count($files));

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        $content = $this->generateMarkdown($files, $folder, $bar);

        $bar->finish();
        $this->newLine(2);

        File::put($outputPath, $content);

        $this->info("✅ Markdown файл создан: {$outputPath}");
        $this->info('Размер файла: '.$this->formatBytes(File::size($outputPath)));

        return 0;
    }

    /**
     * Получить список файлов с фильтрацией
     */
    protected function getFiles($path, $extensions, $ignorePatterns, $recursive)
    {
        $allFiles = $recursive
            ? File::allFiles($path)
            : File::files($path);

        return collect($allFiles)
            ->filter(function ($file) use ($extensions, $ignorePatterns) {
                // Фильтр по расширениям
                if (! empty($extensions)) {
                    $ext = $file->getExtension();
                    if (! in_array($ext, $extensions)) {
                        return false;
                    }
                }

                // Фильтр по паттернам игнорирования
                foreach ($ignorePatterns as $pattern) {
                    if (Str::is($pattern, $file->getFilename())) {
                        return false;
                    }
                }

                return true;
            })
            ->values()
            ->toArray();
    }

    /**
     * Сгенерировать Markdown контент
     */
    protected function generateMarkdown($files, $baseFolder, $bar)
    {
        $content = "# Содержимое папки: {$baseFolder}\n\n";
        $content .= 'Сгенерировано: '.now()->format('Y-m-d H:i:s')."\n\n";
        $content .= "## Структура файлов\n\n";

        // Добавляем структуру
        $structure = $this->generateStructure($files);
        $content .= "```\n{$structure}\n```\n\n";

        $content .= "## Содержимое файлов\n\n";

        foreach ($files as $file) {
            $relativePath = str_replace(base_path().'/', '', $file->getPathname());
            $extension = $file->getExtension();

            $content .= "### {$relativePath}\n\n";
            $content .= "```{$extension}\n";

            try {
                $fileContent = File::get($file->getPathname());
                $content .= $fileContent;
            } catch (\Exception $e) {
                $content .= 'Ошибка чтения файла: '.$e->getMessage();
            }

            $content .= "\n```\n\n";

            $bar->advance();
        }

        return $content;
    }

    /**
     * Сгенерировать структуру папок
     */
    protected function generateStructure($files)
    {
        $structure = [];
        foreach ($files as $file) {
            $relativePath = str_replace(base_path().'/', '', $file->getPathname());
            $structure[] = $relativePath;
        }

        sort($structure);

        return implode("\n", $structure);
    }

    /**
     * Форматировать размер файла
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }
}
