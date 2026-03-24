<?php

namespace Database\Seeders;

use App\Enums\LeadPriority;
use App\Enums\LeadStatus;
use App\Enums\PreferredContact;
use App\Enums\RequestType;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Lead;
use App\Models\LeadStatusHistory;
use App\Models\LeadTask;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем или создаем менеджеров
        $managers = User::whereHas('roles', function ($query) {
            $query->where('slug', 'manager');
        })->get();

        if ($managers->isEmpty()) {
            $manager = User::factory()->create([
                'name' => 'Менеджер Иванов',
                'email' => 'manager@narrative.ru',
                'password' => bcrypt('password'),
            ]);
            $manager->roles()->attach(2); // предполагаем, что role_id=2 для менеджера

            $managers = collect([$manager]);
        }

        // Создаем 50 тестовых заявок
        for ($i = 1; $i <= 50; $i++) {
            $status = $this->getRandomStatus();
            $priority = $this->getRandomPriority();
            $requestType = $this->getRandomRequestType();
            $createdAt = Carbon::now()->subDays(rand(1, 30));

            $lead = Lead::create([
                'lead_number' => 'LEAD-'.date('Y').date('m').'-'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $this->getRandomName(),
                'phone' => '+7'.rand(900, 999).rand(1000000, 9999999),
                'email' => 'client'.$i.'@example.com',
                'company_name' => rand(0, 1) ? $this->getRandomCompany() : null,
                'position' => rand(0, 1) ? $this->getRandomPosition() : null,
                'telegram' => rand(0, 1) ? '@user'.$i : null,
                'whatsapp' => rand(0, 1) ? '+7'.rand(900, 999).rand(1000000, 9999999) : null,
                'preferred_contact' => $this->getRandomPreferredContact(),
                'request_type' => $requestType,
                'service_type' => $this->getRandomServiceType($requestType),
                'message' => $this->getRandomMessage($requestType),
                'form_data' => $this->generateFormData(),
                'budget_from' => rand(0, 1) ? rand(10000, 50000) : null,
                'budget_to' => rand(0, 1) ? rand(50000, 500000) : null,
                'desired_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 30)) : null,
                'desired_time' => rand(0, 1) ? Carbon::now()->setTime(rand(9, 18), 0) : null,
                'status' => $status,
                'priority' => $priority,
                'source' => $this->getRandomSource(),
                'campaign' => rand(0, 1) ? $this->getRandomCampaign() : null,
                'assigned_to' => rand(0, 1) ? $managers->random()->id : null,
                'assigned_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 5)) : null,
                'processed_by' => rand(0, 1) ? $managers->random()->id : null,
                'processed_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 10)) : null,
                'called_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 3)) : null,
                'next_call_at' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 5)) : null,
                'call_attempts' => rand(0, 3),
                'manager_notes' => rand(0, 1) ? $this->getRandomNote() : null,
                'communication_history' => $this->generateCommunicationHistory(),
                'loss_reason' => $status === LeadStatus::LOST ? $this->getRandomLossReason() : null,
                'ip_address' => rand(0, 1) ? long2ip(rand(0, 4294967295)) : null,
                'user_agent' => rand(0, 1) ? $this->getRandomUserAgent() : null,
                'referrer' => rand(0, 1) ? $this->getRandomReferrer() : null,
                'landing_page' => rand(0, 1) ? $this->getRandomLandingPage() : null,
                'utm_params' => rand(0, 1) ? $this->generateUtmParams() : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt->addDays(rand(1, 5)),
            ]);

            // Создаем историю статусов
            $this->createStatusHistory($lead);

            // Создаем задачи для некоторых лидов
            if (rand(0, 1)) {
                $this->createTasks($lead, $managers);
            }
        }

        $this->command->info('Создано 50 тестовых заявок');
    }

    protected function getRandomStatus(): LeadStatus
    {
        $statuses = LeadStatus::cases();

        return $statuses[array_rand($statuses)];
    }

    protected function getRandomPriority(): LeadPriority
    {
        $priorities = LeadPriority::cases();

        return $priorities[array_rand($priorities)];
    }

    protected function getRandomRequestType(): RequestType
    {
        $types = RequestType::cases();

        return $types[array_rand($types)];
    }

    protected function getRandomPreferredContact(): PreferredContact
    {
        $contacts = PreferredContact::cases();

        return $contacts[array_rand($contacts)];
    }

    protected function getRandomName(): string
    {
        $firstNames = ['Александр', 'Дмитрий', 'Максим', 'Сергей', 'Андрей', 'Алексей', 'Иван', 'Елена', 'Ольга', 'Наталья', 'Татьяна', 'Мария'];
        $lastNames = ['Иванов', 'Петров', 'Сидоров', 'Смирнов', 'Кузнецов', 'Попов', 'Васильев', 'Михайлов', 'Федоров', 'Морозов'];

        return $lastNames[array_rand($lastNames)].' '.$firstNames[array_rand($firstNames)];
    }

    protected function getRandomCompany(): string
    {
        $companies = ['ООО "Ромашка"', 'ИП Иванов', 'АО "ТехноСервис"', 'ООО "СтройИнвест"', 'ЗАО "МедиаГрупп"', 'ООО "РекламаПро"'];

        return $companies[array_rand($companies)];
    }

    protected function getRandomPosition(): string
    {
        $positions = ['Генеральный директор', 'Коммерческий директор', 'Маркетолог', 'Менеджер по рекламе', 'Собственник', 'Начальник отдела маркетинга'];

        return $positions[array_rand($positions)];
    }

    protected function getRandomServiceType(RequestType $type): string
    {
        $services = [
            RequestType::CALCULATE->value => ['Наружная реклама', 'Вывески', 'Баннеры', 'Штендеры', 'Световые короба'],
            RequestType::ORDER->value => ['Рекламный щит 3x6', 'Вывеска на фасад', 'Баннер на заборе', 'Световой короб'],
            RequestType::QUESTION->value => ['Цены на монтаж', 'Сроки изготовления', 'Материалы', 'Дизайн-проект'],
            RequestType::CONSULTATION->value => ['По наружной рекламе', 'По разрешительной документации', 'По согласованию'],
            RequestType::CALLBACK->value => ['Уточнить детали', 'Записаться на встречу'],
        ];

        $list = $services[$type->value] ?? $services[RequestType::CALCULATE->value];

        return $list[array_rand($list)];
    }

    protected function getRandomMessage(RequestType $type): string
    {
        $messages = [
            RequestType::CALCULATE->value => [
                'Нужен расчет стоимости вывески на фасад',
                'Сколько будет стоить изготовление баннера 3x6?',
                'Рассчитайте пожалуйста стоимость рекламного щита',
            ],
            RequestType::ORDER->value => [
                'Хочу заказать вывеску для магазина',
                'Нужен срочный заказ светового короба',
                'Заказать изготовление рекламной конструкции',
            ],
            RequestType::QUESTION->value => [
                'Какие сроки изготовления?',
                'Делаете согласование с администрацией?',
                'Какие гарантии на монтаж?',
            ],
            RequestType::CONSULTATION->value => [
                'Нужна консультация по наружной рекламе',
                'Помогите выбрать тип вывески',
                'Хочу узнать подробнее о ваших услугах',
            ],
            RequestType::CALLBACK->value => [
                'Позвоните мне в рабочее время',
                'Жду звонка для уточнения деталей',
                'Перезвоните как будет возможность',
            ],
        ];

        $list = $messages[$type->value] ?? $messages[RequestType::CALLBACK->value];

        return $list[array_rand($list)];
    }

    protected function getRandomSource(): string
    {
        $sources = ['website', 'yandex_direct', 'google_ads', 'instagram', 'telegram', 'referral', 'call', 'email'];

        return $sources[array_rand($sources)];
    }

    protected function getRandomCampaign(): string
    {
        $campaigns = ['brand', 'retargeting', 'season_sale', 'new_year', 'summer'];

        return $campaigns[array_rand($campaigns)];
    }

    protected function getRandomNote(): string
    {
        $notes = [
            'Клиент хочет обсудить детали лично',
            'Просил перезвонить после 15:00',
            'Интересуется оптовыми ценами',
            'Нужно подготовить коммерческое предложение',
            'Клиент настроен решительно, высокая вероятность сделки',
            'Перезвонить через неделю',
        ];

        return $notes[array_rand($notes)];
    }

    protected function getRandomLossReason(): string
    {
        $reasons = [
            'Не сошлись в цене',
            'Выбрали конкурентов',
            'Ппередумали делать рекламу',
            'Нет бюджета',
            'Не устроили сроки',
            'Сменили направление бизнеса',
        ];

        return $reasons[array_rand($reasons)];
    }

    protected function getRandomUserAgent(): string
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15',
            'Mozilla/5.0 (Linux; Android 10; SM-G975F) AppleWebKit/537.36',
        ];

        return $agents[array_rand($agents)];
    }

    protected function getRandomReferrer(): string
    {
        $referrers = [
            'https://yandex.ru/search/',
            'https://www.google.com/search',
            'https://www.instagram.com/',
            'https://t.me/',
            'https://vk.com/',
            'direct',
        ];

        return $referrers[array_rand($referrers)];
    }

    protected function getRandomLandingPage(): string
    {
        $pages = [
            '/',
            '/services/outdoor',
            '/products/billboards',
            '/portfolio',
            '/contacts',
            '/calculator',
        ];

        return $pages[array_rand($pages)];
    }

    protected function generateFormData(): array
    {
        return [
            'form_id' => 'contact_form_'.rand(1, 5),
            'form_name' => 'Форма обратной связи',
            'fields' => [
                'name' => 'value',
                'phone' => 'value',
                'comment' => 'comment text',
            ],
        ];
    }

    protected function generateUtmParams(): array
    {
        return [
            'utm_source' => $this->getRandomSource(),
            'utm_medium' => rand(0, 1) ? 'cpc' : 'organic',
            'utm_campaign' => $this->getRandomCampaign(),
            'utm_content' => 'ad_'.rand(1, 100),
            'utm_term' => 'keyword_'.rand(1, 10),
        ];
    }

    protected function generateCommunicationHistory(): array
    {
        $history = [];
        $events = rand(0, 5);

        for ($i = 0; $i < $events; $i++) {
            $history[] = [
                'type' => rand(0, 1) ? 'call' : 'note',
                'date' => Carbon::now()->subDays(rand(1, 10))->format('Y-m-d H:i:s'),
                'description' => $this->getRandomNote(),
            ];
        }

        return $history;
    }

    protected function createStatusHistory(Lead $lead): void
    {
        $statuses = LeadStatus::cases();
        $statusCount = rand(1, min(3, count($statuses)));

        // Выбираем случайные статусы для истории
        $statusIndices = array_rand(range(0, count($statuses) - 1), $statusCount);
        if (! is_array($statusIndices)) {
            $statusIndices = [$statusIndices];
        }
        sort($statusIndices);

        for ($i = 0; $i < $statusCount; $i++) {
            // Создаем новый экземпляр модели
            $history = new LeadStatusHistory;

            // Заполняем поля по одному
            $history->lead_id = $lead->id;
            $history->new_status = $statuses[$statusIndices[$i]];
            $history->created_at = Carbon::parse($lead->created_at)->addDays($i);
            $history->updated_at = Carbon::parse($lead->created_at)->addDays($i);

            if ($i > 0) {
                $history->old_status = $statuses[$statusIndices[$i - 1]];
            }

            if (rand(0, 1)) {
                $history->comment = 'Автоматическое изменение статуса';
            }

            // Добавляем created_by и updated_by если есть пользователь
            if (Auth::check()) {
                $history->created_by = Auth::id();
                $history->updated_by = Auth::id();
            }
            // Включаем логирование запросов
            DB::enableQueryLog();

            try {
                // Пытаемся сохранить
                $result = $history->save();

            } catch (\Exception $e) {
                $this->command->error('Ошибка при save(): '.$e->getMessage());

                // Получаем последний запрос
                $queries = DB::getQueryLog();
                $lastQuery = end($queries);

                $this->command->error('Последний SQL запрос:');
                $this->command->error('SQL: '.($lastQuery['query'] ?? 'N/A'));
                $this->command->error('Bindings: '.json_encode($lastQuery['bindings'] ?? [], JSON_UNESCAPED_UNICODE));
                $this->command->error('Time: '.($lastQuery['time'] ?? 'N/A'));

                throw $e;
            }
        }
    }

    protected function createTasks(Lead $lead, $managers): void
    {
        $taskCount = rand(1, 3);

        for ($i = 0; $i < $taskCount; $i++) {
            $status = rand(0, 2) ? TaskStatus::PENDING : TaskStatus::COMPLETED;

            LeadTask::create([
                'lead_id' => $lead->id,
                'title' => $this->getRandomTaskTitle(),
                'description' => rand(0, 1) ? $this->getRandomTaskDescription() : null,
                'status' => $status,
                'priority' => $this->getRandomTaskPriority(),
                'due_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 7)) : null,
                'assigned_to' => rand(0, 1) ? $managers->random()->id : null,
                'completed_at' => $status === TaskStatus::COMPLETED ? Carbon::now() : null,
            ]);
        }
    }

    protected function getRandomTaskTitle(): string
    {
        $titles = [
            'Позвонить клиенту',
            'Подготовить КП',
            'Отправить договор',
            'Согласовать макет',
            'Уточнить детали',
            'Напомнить о встрече',
        ];

        return $titles[array_rand($titles)];
    }

    protected function getRandomTaskDescription(): string
    {
        $descriptions = [
            'Обсудить детали проекта',
            'Уточнить требования к макету',
            'Подготовить смету с учетом пожеланий',
            'Согласовать сроки выполнения',
            'Выслать примеры работ',
        ];

        return $descriptions[array_rand($descriptions)];
    }

    protected function getRandomTaskPriority(): TaskPriority
    {
        $priorities = TaskPriority::cases();

        return $priorities[array_rand($priorities)];
    }
}
