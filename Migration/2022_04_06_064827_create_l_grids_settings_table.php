<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLGridsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_grids_settings', function (Blueprint $table) {
            $table->primary(['grid_id', 'field_name']);
            $table->integer('grid_id');
            $table->string('field_name');//Название поля в гриде
            $table->boolean('show');//Показывать ли  поле
            $table->integer('sort');//100?200?300
            $table->integer('width');//Ширина поля(рх)

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
        Schema::dropIfExists('l_grids_settings');
    }
}
