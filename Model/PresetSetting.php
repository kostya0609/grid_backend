<?php

namespace App\Modules\Grids\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresetSetting extends Model
{
    protected $table = 'l_grids_preset_settings';

    public function preset():BelongsTo
    {
        return $this->belongsTo(FilterPreset::class);
    }
}
