<?php

namespace App\Modules\Grids\Action;

use App\Modules\Grids\Model\Grid;
use App\Modules\Grids\Model\Setting;

class GridAction
{
    public static function getGrid($request)
    {
        return Grid::where([
            ['name'     ,     '=', $request->name    ],
            ['user_id'  ,     '=', $request->user_id ],
            ['module'   ,     '=', $request->module  ]
        ])->first();
    }

    public static function newGrid($request)
    {
        $grid           = new Grid();
        $grid->name     = $request->name;
        $grid->user_id  = $request->user_id;
        $grid->module   = $request->module;
        $grid->context  = $request->context;
        $grid->save();

        return $grid;
    }

    public static function setGridSettings($grid_id,$data)
    {
        Setting::where('grid_id','=',$grid_id)->delete();
        foreach($data as $key => $item)
        {
            $setting                = new Setting();
            $setting->grid_id       = $grid_id;
            $setting->field_name    = $key;
            $setting->show          = $item['show'];
            $setting->sort          = $item['sort'];
            $setting->width         = $item['width'];
            $setting->save();
        }
    }

    public static function getGridSettings($grid_id)
    {
        return Setting::where('grid_id', '=', $grid_id)
            ->get()
            ->flatMap(function($item)
            {
                return [
                    $item->field_name => [
                        'show' => (bool)$item->show,
                        'sort' => $item->sort,
                        'width'=> $item->width
                    ]
                ];
            });
    }
}
