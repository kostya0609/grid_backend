<?php

namespace App\Modules\Grids\Controllers;

use App\Modules\Grids\Action\GridAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class GridController extends Controller
{
    public function addOrGet(Request $request):JsonResponse
    {
        $validation = Validator::make($request->all(),
            [
                'name'      => 'required',
                'user_id'   => 'required|gt:0',
                'module'    => 'required',
            ],[
                'name.required'      => 'Не корректный параметр name',
                'user_id.required'   => 'Отсутсвует параметр user_id',
                'user_id.gt'         => 'Параметр user_id = 0',
                'module.required'    => 'Не корректный параметр module'
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
            $grid = GridAction::getGrid($request);
            if(isset($grid))
            {
                return response()->json(['status' => 'success', 'grid_id' => $grid->id]);
            }
            else
            {
                $grid = GridAction::newGrid($request);
                return response()->json(['status' => 'success', 'grid_id' => $grid->id]);
            }
        }
    }

    public function addSetting(Request $request):JsonResponse
    {
        $validation = Validator::make($request->all(),
            [
                'grid_id'           => 'required|gt:0',
                'data'              => 'required',
                'data.*.show'       => 'required',
                'data.*.sort'       => 'required',
                'data.*.width'      => 'required'
            ],
            [
                'grid_id.required'  => 'Отсутсвует параметр grid_id',
                'grid_id.gt'        => 'Параметр grid_id = 0',
            ]);
        if($validation->fails())
        {
            return response()->json(
                [
                    'status'    => 'error',
                    'message'   => implode('<br>',$validation->errors()->all())
                ]
            );
        }
        else
        {
            GridAction::setGridSettings($request->grid_id, $request->data);
            return response()->json(['status' => 'success']);
        }
    }

    public function getSetting(Request $request):JsonResponse
    {
        $validation = Validator::make($request->all(),
            [
                'grid_id'           => 'required|gt:0',
            ],
            [
                'grid_id.required'  => 'Отсутсвует параметр grid_id',
                'grid_id.gt'        => 'Параметр grid_id = 0',
            ]);
        if($validation->fails())
        {
            return response()->json(
                [
                    'status'    => 'error',
                    'message'   => implode('<br>',$validation->errors()->all())
                ]
            );
        }
        else
        {
            $gridSettings = GridAction::getGridSettings($request->grid_id);
            return response()->json(['status' => 'success', 'data' => $gridSettings]);
        }
    }
}
