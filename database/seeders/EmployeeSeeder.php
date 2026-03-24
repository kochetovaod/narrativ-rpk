<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Массив с данными сотрудников
        $employees = [
            [
                'name' => 'Андрей Викторович Соколов',
                'position' => 'Руководитель производства',
                'bio' => 'Технарь с опытом. Пишет про материалы, ошибки монтажа, производственные нюансы — то, что знает изнутри.',
                'image' => '1.png', // Предполагаемое имя файла
            ],
            [
                'name' => 'Марина Сергеевна Ларина',
                'position' => 'Ведущий дизайнер',
                'bio' => 'Отвечает за визуальную часть: дизайн, тренды, интерьерную рекламу, эстетику вывесок.',
                'image' => '2.png', // Предполагаемое имя файла
            ],
            [
                'name' => 'Дмитрий Алексеевич Борисов',
                'position' => 'Менеджер по работе с клиентами',
                'bio' => 'Ближе всего к клиенту — пишет про согласование, бюджет, практические кейсы и лёгкий контент (гороскоп, тест).',
                'image' => '3.png', // Предполагаемое имя файла
            ],
        ];

        foreach ($employees as $employeeData) {
            // Ищем attachment по имени файла
            $attachment = Attachment::where('original_name', $employeeData['image'])->first();

            // Если не нашли по точному имени, пробуем найти по частичному совпадению
            if (! $attachment) {
                $attachment = Attachment::where('original_name', 'like', '%'.pathinfo($employeeData['image'], PATHINFO_FILENAME).'%')->first();
            }

            $employee = new Employee;
            // Создаем сотрудника
            $employee->forceFill([
                'title' => $employeeData['name'],
                'excerpt' => $employeeData['position'],
                'content' => $employeeData['bio'],
                'preview_id' => $attachment ? $attachment->id : null,
                'active' => true,
                'published_at' => now(),
                'sort' => 0,
            ]);

            $employee->save();

            $this->command->info("Создан сотрудник: {$employeeData['name']}".($attachment ? '' : ' (без аватарки)'));
        }
    }

    /**
     * Получить инициалы из ФИО
     */
    private function getInitials(string $fullName): string
    {
        $parts = explode(' ', $fullName);
        $initials = '';

        foreach ($parts as $part) {
            if (! empty($part)) {
                $initials .= mb_substr($part, 0, 1, 'UTF-8');
            }
        }

        return $initials;
    }
}
