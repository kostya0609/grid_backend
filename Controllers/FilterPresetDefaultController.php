<?php

namespace App\Modules\Grids\Controllers;

use App\Modules\Grids\Action\FilterAction;
use App\Modules\Grids\Model\FilterPresetDefault;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FilterPresetDefaultController extends Controller
{
    public function add(Request $request):JsonResponse
    {
        foreach($request->data as $key => $item)
        {
            $newDefault             = new FilterPresetDefault();
            $newDefault->module     = $request->module;
            $newDefault->grid_name  = $request->grid_name;
            FilterAction::addPresetSetting($newDefault, $key, $item);
        }
        return response()->json(['status' => 'success']);
    }

    public function get(Request $request):JsonResponse
    {
        $data = FilterPresetDefault::where(
            [
                ['module',      '=', $request->module   ],
                ['grid_name',   '=', $request->grid_name]
            ])
            ->get()
            ->flatMap(function($item)
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
                        'focus'         => $item->focus,
                        'option'        => ($item->option != null) ? json_decode($item->option):[]
                    ]
                ];
            });

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
