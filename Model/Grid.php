<?php

namespace App\Modules\Grids\Model;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $table = 'l_grids';

    public function gridSettings()
    {
        return $this->hasMany(Setting::class);
    }

    public function filterSettings()
    {
        return $this->hasMany(PresetSetting::class);
    }

    public function filterPresets()
    {
        return $this->hasMany(FilterPreset::class);
    }
}
