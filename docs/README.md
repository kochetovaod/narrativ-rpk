# Сайт компании Нарратив

## Требования
- PHP ^8.4
- Composer
- MySQL/MariaDB/PostgreSQL/SQLite
- Node.js & NPM (для фронтенда)

## Установка

### 1. Клонирование репозитория
```bash
git clone [repository-url] my-project
cd my-project
```

### 2. Установка зависимостей PHP
```bash
composer install
```

### 3. Настройка окружения
```bash
cp .env.example .env
php artisan key:generate
```
Отредактируйте `.env` файл, указав параметры подключения к базе данных.

### 4. Установка зависимостей для фронтенда (опционально)
```bash
npm install && npm run build
```

### 5. Настройка базы данных
```bash
php artisan migrate
```

### 6. Создание администратора (для Orchid)
```bash
php artisan orchid:admin admin admin@example.com password
```

### 7. Запуск сервера
```bash
php artisan serve
```

## Структура проекта
Проект следует принципам SOLID, DRY, KISS и включает следующие пакеты:
- **artesaos/seotools** - для SEO оптимизации
- **cviebrock/eloquent-sluggable** - для создания ЧПУ-ссылок
- **intervention/image** - для работы с изображениями
- **maatwebsite/excel** - для импорта/экспорта Excel
- **orchid/platform** - для административной панели
- **propaganistas/laravel-phone** - для валидации телефонных номеров
- **spatie/laravel-image-optimizer** - для оптимизации изображений
- **spatie/laravel-sitemap** - для генерации sitemap

## Тестирование
```bash
php artisan test
```

## Документация
Документация по проекту находится в директории `/docs`.

## Создание моделей, фабрик, миграций и сидеров

```
php artisan make:model Setting -mfs
php artisan make:model Client -mfs
php artisan make:model Equipment -mfs
php artisan make:model Blog -mfs
php artisan make:model Slider -mfs
php artisan make:model Advantage -mfs
php artisan make:model Page -mfs

php artisan make:model Service -mfs
php artisan make:model ProductCategory -mfs
php artisan make:model Product -mfs
php artisan make:model Portfolio -mfs

php artisan make:model PortfolioService -mfs
php artisan make:model PortfolioProduct -mfs

php artisan make:model Lead -mfs
php artisan make:model SEO -mfs

php artisan make:model SiteStatistic -mfs
php artisan make:model FAQ -mfs

php artisan orchid:rows Settings/GeneralSettingsLayout
php artisan orchid:rows Settings/ContactsSettingsLayout
php artisan orchid:rows Settings/SocialSettingsLayout
php artisan orchid:rows Settings/SeoSettingsLayout
php artisan orchid:rows Settings/TelegramSettingsLayout
php artisan orchid:rows Settings/EmailSettingsLayout
php artisan orchid:rows Settings/DesignSettingsLayout
php artisan orchid:rows Settings/NotificationsSettingsLayout
php artisan orchid:rows Settings/AbstractSettingsLayout