<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_category_filter_values', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('filter_id')->comment('Фильтр');
            $table->string('value', 255)->comment('Значение фильтра');
            $table->integer('sort')->default(0);
            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->foreign('filter_id')
                ->references('id')
                ->on('product_category_filters')
                ->onDelete('CASCADE');

            $table->comment('Возможные значения фильтра');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_category_filter_values');
    }
};
