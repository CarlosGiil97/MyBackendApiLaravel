<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Teams;

class TeamsController extends Controller
{

    public function index()
    {
        return Teams::all();
    }

    public function show($id)
    {
        try {
            $team = Teams::find($id);

            if (!$team) {
                return response()->json([
                    'msg' => 'Equipo no encontrado',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'msg' => 'Equipo obtenido con éxito',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }



    public function store(Request $request)
    {

        if (Teams::where('name', $request->name)->exists()) {
            return response()->json([
                'msg' => 'El equipo ' . $request->name . ' ya existe en nuestro sistema',
                'data' => null
            ], 404);
        }

        try {
            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'sometimes|string',
                'founded' => 'sometimes|integer',
                'logo' => 'sometimes|string',
                'colors' => 'sometimes|string',
            ]);

            $team = Teams::create($data);
            return response()->json([
                'msg' => 'Información guardada con exito',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }


        return Teams::create($data);
    }


    public function update(Request $request, $id)
    {

        try {

            $team = Teams::find($id);

            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'sometimes|string',
                'founded' => 'sometimes|integer',
                'logo' => 'sometimes|string',
                'colors' => 'sometimes|string',
            ]);

            $team->update($data);

            return response()->json([
                'msg' => 'Información actualizada con exito',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $team = Teams::find($id);
            $team->delete();
            return response()->json([
                'msg' => 'Equipo eliminado con exito',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }
}
