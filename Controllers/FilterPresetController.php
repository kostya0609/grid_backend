<?php

namespace App\Modules\Grids\Controllers;

use App\Modules\Grids\Action\FilterAction;
use App\Modules\Grids\Model\FilterPreset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class FilterPresetController extends Controller
{
    public function add(Request $request):JsonResponse
    {
        $validation = Validator::make($request->all(),
            [
                'name'      => 'required',
                'grid_id'   => 'required|gt:0',
                'data'      => 'required|array'
            ],
            [
                'name.required'     => 'Отсутсвует параметр name',
                'grid_id.required'  => 'Отсутсвует параметр grid_id',
                'grid_id.gt'        => 'Параметр grid_id = 0',
                'data.required'     => 'Отсутсвует параметр data',
                'data.array'        => 'data не массив'
            ]);
        if($validation->fails())
        {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => implode('<br>',$validation->errors()->all())
                ]
            );
        }
        else
        {
            $newFilterPreset = FilterAction::addPreset($request);

            return response()->json(['status' => 'success', 'preset_id' => $newFilterPreset->id]);
        }
    }

    public function list(Request $request):JsonResponse
    {
        if($request->grid_id > 0)
        {
            $presets = FilterAction::listPreset($request->grid_id);
            return response()->json(['status' => 'success', 'data' => $presets]);
        }
        else
        {
            return response()->json(['status' => 'error']);
        }
    }

    public function edit(Request $request):JsonResponse
    {
        if($request->preset_id > 0)
        {
            FilterAction::editPreset($request->preset_id, $request->data);
            return response()->json(['status' => 'success']);
        }
        else
        {
            return response()->json(['status' => 'error']);
        }
    }

    public function delete(Request $request):JsonResponse
    {
        if($request->preset_id > 0)
        {
            $preset = FilterPreset::find($request->preset_id);
            $preset->presetSettings()->delete();
            $preset->delete();
            return response()->json(['status' => 'success']);
        }
        else
        {
            return response()->json(['status' => 'error']);
        }
    }
}
