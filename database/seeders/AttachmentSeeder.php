<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        // Сохраняем основные изображения
        $this->saveImagesFromFolder('main', 'main', 'Логотипы и иконки');
        // Сохраняем изображения для блога из папки seed/blog
        $this->saveImagesFromFolder('blog', 'blog', 'Изображение блога');
        // Сохраняем изображения для авторов из папки seed/employees
        $this->saveImagesFromFolder('employees', 'employees', 'Изображение сотрудника');
        // Сохраняем изображения для клиентов из папки seed/clients
        $this->saveImagesFromFolder('clients', 'clients', 'Изображение клиента');
        // Сохраняем изображения для оборудования из папки seed/equipment
        $this->saveImagesFromFolder('equipment', 'equipment', 'Изображение оборудования');
        // Сохраняем изображения для слайдера из папки seed/slider
        $this->saveImagesFromFolder('slider', 'slider', 'Изображение слайдера');
        // Сохраняем изображения для портфолио из папки seed/portfolio
        $this->saveImagesFromFolder('portfolio', 'portfolio', 'Изображение работы портфолио');
        // Сохраняем изображения для страниц из папки seed/pages
        $this->saveImagesFromFolder('pages', 'pages', 'Изображение для страниц');
        // Сохраняем изображения для услуг из папки seed/pages
        $this->saveImagesFromFolder('services', 'services', 'Изображение для услуг');
        $this->saveImagesFromFolder('product_categories', 'product_categories', 'Изображение для услуг');

    }

    private function saveImagesFromFolder(string $folder, string $group, string $descriptionPrefix): void
    {
        $path = storage_path('app/public/seed/'.$folder);

        if (! is_dir($path)) {
            $this->command->warn("Папка seed/{$folder} не найдена");

            return;
        }

        // Получаем все файлы из папки
        $files = scandir($path);

        foreach ($files as $file) {
            // Пропускаем системные директории
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $path.'/'.$file;

            // Проверяем, что это файл, а не директория
            if (! is_file($filePath)) {
                continue;
            }

            // Проверяем, что файл является изображением
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'webmanifest'];

            if (! in_array($extension, $allowedExtensions)) {
                $this->command->warn("Файл {$file} не является изображением, пропускаем");

                continue;
            }

            // Генерируем имя без расширения для alt и description
            $nameWithoutExt = pathinfo($file, PATHINFO_FILENAME);

            $uploadedFile = new UploadedFile(
                $filePath,
                $file,
                null,
                null,
                true
            );

            $attachment = (new File($uploadedFile))
                ->path('attachments/'.$group)
                ->load();

            // Обновляем дополнительные поля
            $attachment->update([
                'description' => "{$descriptionPrefix}: {$nameWithoutExt}",
                'alt' => $nameWithoutExt,
                'group' => $group,
                'user_id' => 1,
            ]);
        }
        $this->command->info("Созданы attachments для {$group}");
    }
}
