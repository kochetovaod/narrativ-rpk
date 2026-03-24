<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Polymorphic relation
            $table->string('seoable_type', 255)->comment('Класс модели (Service, Product, etc.)');
            $table->unsignedBigInteger('seoable_id')->comment('ID записи');

            // SEO-поля
            $table->string('title', 255)->nullable()->comment('SEO Title (meta title)');
            $table->text('description')->nullable()->comment('SEO Description (meta description)');
            $table->string('keywords', 500)->nullable()->comment('SEO Keywords (устаревшее, но можно хранить)');

            // Open Graph (для соцсетей)
            $table->string('og_title', 255)->nullable()->comment('Open Graph Title');
            $table->text('og_description')->nullable()->comment('Open Graph Description');
            $table->unsignedInteger('og_image_id')->nullable()->comment('ID изображения для OG из attachments');

            // Дополнительно
            $table->string('canonical_url', 500)->nullable()->comment('Канонический URL (если отличается)');
            $table->string('robots', 100)->default('index, follow')->comment('Robots meta (index, noindex и т.д.)');

            // Timestamps
            $table->timestamps();

            // Уникальный индекс для polymorphic relation
            $table->unique(['seoable_type', 'seoable_id'], 'seo_seoable_type_seoable_id_unique');

            // Индексы
            $table->index('seoable_type', 'seo_seoable_type_index');

            // Внешние ключи
            $table->foreign('og_image_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_e_o_s');
    }
};
