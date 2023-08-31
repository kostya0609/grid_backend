<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LGridsPresetSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('l_grids_preset_settings',function (Blueprint $table)
        {
            $table->text('focus')->nullable()->after('query');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('l_grids_preset_settings',function (Blueprint $table)
        {
            $table->dropColumn('focus');
        });
    }
}
