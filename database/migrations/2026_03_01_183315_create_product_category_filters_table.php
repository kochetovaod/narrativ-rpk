<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_category_filters', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->comment('Категория, к которой относится фильтр');

            $table->string('code', 100)->comment('Системный код фильтра (backlight, material)');
            $table->string('title', 255)->comment('Название фильтра');
            $table->string('type', 50)->default('checkbox')->comment('Тип фильтра: checkbox | radio | select');

            $table->integer('sort')->default(0);
            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->unique(['category_id', 'code'], 'category_filter_unique');

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('CASCADE');

            $table->comment('Фильтры, доступные в рамках категории');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_category_filters');
    }
};
