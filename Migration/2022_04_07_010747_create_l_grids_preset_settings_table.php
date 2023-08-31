<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLGridsFilterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_grids_preset_settings', function (Blueprint $table) {
            $table->id();

            $table->string('preset_id');

            $table->string('field_name');//Ключ поля
            $table->string('name');//Имя поля
            $table->string('type');//Тип

            $table->string('min')->nullable();//Минимальное значение
            $table->string('max')->nullable();//Максимальное значение

            $table->string('operation')->nullable();//=<>...
            $table->boolean('multiple')->nullable();
            $table->text('value')->nullable();
            $table->text('query')->nullable();
            $table->text('option')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_grids_preset_settings');
    }
}
