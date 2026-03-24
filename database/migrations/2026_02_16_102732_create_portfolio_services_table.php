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
        Schema::create('portfolio_services', function (Blueprint $table) {
            // Ключи
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('service_id');

            // Дополнительные поля (если нужны)
            $table->integer('sort')->default(0)->comment('Порядок в списке');
            $table->timestamps();

            // Первичный составной ключ
            $table->primary(['portfolio_id', 'service_id'], 'portfolio_service_primary');

            // Индексы
            $table->index('portfolio_id', 'pws_portfolio_id_index');
            $table->index('service_id', 'pws_service_id_index');
            $table->index('sort', 'pws_sort_index');

            // Внешние ключи
            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolio')
                ->onDelete('CASCADE');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_services');
    }
};
