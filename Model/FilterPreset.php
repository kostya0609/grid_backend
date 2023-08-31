<?php

namespace App\Modules\Grids\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilterPreset extends Model
{
    protected $table = 'l_grids_filter_presets';
    /**
     * @var mixed
     */

    public function grid():BelongsTo
    {
        return $this->belongsTo(Grid::class);
    }

    public function presetSettings():HasMany
    {
        return $this->hasMany(PresetSetting::class, 'preset_id', 'id');
    }
}
