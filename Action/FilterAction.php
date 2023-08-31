<?php

namespace App\Modules\Grids\Action;

use App\Modules\Grids\Model\FilterPreset;
use App\Modules\Grids\Model\PresetSetting;

class FilterAction
{
    public static  function addPreset($request)
    {
        $newFilterPreset            = new FilterPreset();
        $newFilterPreset->name      = $request->name;
        $newFilterPreset->grid_id   = $request->grid_id;
        $newFilterPreset->save();

        //Сохранение настроек пресета
        foreach($request->data as $key => $item)
        {
            $newPresetSetting = new PresetSetting();
            $newPresetSetting->preset_id = $newFilterPreset->id;
            FilterAction::addPresetSetting($newPresetSetting, $key, $item);
        }
        return $newFilterPreset;
    }

    public static function addPresetSetting($model, $key, $item)
    {
        $model->field_name = $key;
        $model->name       = $item['name'];
        $model->type       = $item['type'];
        $model->min        = (array_key_exists('min',       $item)) ? $item['min']:'';
        $model->max        = (array_key_exists('max',       $item)) ? $item['max']:'';
        $model->operation  = (array_key_exists('operation', $item)) ? $item['operation']:'';
        $model->multiple   = (array_key_exists('multiple',  $item)) ? $item['multiple']:0;
        $model->value      = (array_key_exists('value',     $item)) ? json_encode($item['value']):'';
        $model->query      = (array_key_exists('query',     $item)) ? $item['query']:'';
        $model->focus      = (array_key_exists('focus',     $item)) ? $item['focus']:'';
        $model->option     = (array_key_exists('option',    $item)) ? json_encode($item['option']):'';
        $model->save();
    }

    public static function listPreset($grid_id)
    {
        return FilterPreset::where('grid_id', '=', $grid_id)
            ->get()
            ->map(function($item)
            {
                return [
                    'id'   => $item->id,
                    'name' => $item->name,
                    'data' => $item->presetSettings->flatMap(function($item)
                    {
                        return [
                            $item->field_name => [
                                'name'          => $item->name,
                                'type'          => $item->type,
                                'min'           => $item->min,
                                'max'           => $item->max,
                                'operation'     => $item->operation,
                                'multiple'      => (bool)$item->multiple,
                                'value'         => json_decode($item->value),
                                'query'         => $item->query,
                                'option'        => ($item->option != null) ? json_decode($item->option):[]
                            ]
                        ];
                    })
                ];
            });
    }

    public static function editPreset($preset_id, $data)
    {
        $preset = FilterPreset::find($preset_id);
        $preset->presetSettings()->delete();
        foreach($data as $key => $item)
        {
            $newPresetSetting = new PresetSetting();
            $newPresetSetting->preset_id = $preset->id;
            FilterAction::addPresetSetting($newPresetSetting, $key, $item);
        }
    }
}
