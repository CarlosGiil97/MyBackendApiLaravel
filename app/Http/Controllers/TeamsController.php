<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Teams;

use App\Helpers\ImageHelper;

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
        // Verifica si el equipo ya existe por nombre
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
                'logo' => 'sometimes|image',
                'colors' => 'sometimes|string',
            ]);

            $team = Teams::create($data);

            if ($request->hasFile('logo')) {
                $logoPath = ImageHelper::saveImage($request->file('logo'), 'teams/' . $team->id);
                $team->update(['logo' => $logoPath]);
            }

            // Retorna la respuesta con éxito
            return response()->json([
                'msg' => 'Información guardada con exito',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $team = Teams::find($id);

            if (!$team) {
                return response()->json([
                    'msg' => 'Equipo no encontrado',
                    'data' => null
                ], 404);
            }

            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'sometimes|string',
                'founded' => 'sometimes|integer',
                'logo' => 'sometimes|image',
                'colors' => 'sometimes|string',
            ]);

            $team->update($data);

            if ($request->hasFile('logo')) {
                $logoPath = ImageHelper::saveImage($request->file('logo'), 'teams/' . $team->id);
                $team->update(['logo' => $logoPath]);
            }

            return response()->json([
                'msg' => 'Información actualizada con éxito',
                'data' => $team
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
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
