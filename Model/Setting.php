<?php

namespace App\Modules\Grids\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'l_grids_settings';

    public function grid()
    {
        return $this->belongsTo(Grid::class);
    }
}
