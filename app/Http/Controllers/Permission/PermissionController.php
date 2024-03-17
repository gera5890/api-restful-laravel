<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function store(PermissionRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $permission = Permission::create($validatedData);
            DB::commit();
            return response()->json([
                PermissionResource::make($permission)
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear el permiso',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Permission $permission, UpdatePermissionRequest $request){
        DB::beginTransaction();
        try {
            $permission = $permission->update($request->validated);
            DB::commit();
            return response()->json(PermissionResource::make($permission));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar permiso',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
