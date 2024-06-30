<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Season;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Season::orderBy('year', 'DESC')->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Season::where('year', $request->year)->exists()) {
            return response()->json([
                'msg' => 'La temporada ' . $request->year . ' ya existe en nuestro sistema',
                'data' => null
            ], 404);
        }

        try {
            $data = $request->validate([
                'year' => 'required|integer',
            ]);

            $season = Season::create($data);


            // Retorna la respuesta con éxito
            return response()->json([
                'msg' => 'Temporada guardada con exito',
                'data' => $season
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $season = Season::find($id);

            if (!$season) {
                return response()->json([
                    'msg' => 'Temporada no encontrada',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'msg' => 'Temporada obetenida con éxito',
                'data' => $season
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $season = Season::find($id);

            if (!$season) {
                return response()->json([
                    'msg' => 'Temporada no encontrada',
                    'data' => null
                ], 404);
            }

            $data = $request->validate([
                'year' => 'required|integer'
            ]);

            $season->update($data);



            return response()->json([
                'msg' => 'Temporada actualizada con éxito',
                'data' => $season
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $season = Season::find($id);
            $season->delete();
            return response()->json([
                'msg' => 'Temporada eliminada con exito',
                'data' => $season
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }
}
