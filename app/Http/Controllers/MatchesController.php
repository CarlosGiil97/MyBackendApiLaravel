<?php

namespace App\Http\Controllers;

use App\Models\Matches;


use Illuminate\Http\Request;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = Matches::with('teamHome', 'teamAway', 'season', 'tournament')->get();


        return response()->json($matches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'user_id' => 'required',
            'team_id_home' => 'required',
            'team_id_away' => 'required',
            'location' => 'sometimes|string',
            'cc' => 'required|string',
            'date' => 'required|date',
            'season_id' => 'required|integer',
            'tournament_id' => 'required|integer',
            'score_home' => 'nullable',
            'score_away' => 'nullable',
            'winner_id' => 'nullable',
            'result' => 'nullable',
        ]);

        if (Matches::where('team_id_home', $data['team_id_home'])->where('team_id_away', $data['team_id_away'])->where('date', $data['date'])->exists()) {

            return response()->json([
                'msg' => 'Ya existe un mismo partido de ambos equipos en esta fecha',
                'data' => null
            ], 404);
        }

        if ($data['team_id_home'] == $data['team_id_away']) {
            return response()->json([
                'msg' => 'El equipo local no puede ser el mismo que el equipo visitante',
                'data' => null
            ], 404);
        }


        try {

            $match = Matches::create($data);

            $match->load('teamHome', 'teamAway', 'season');

            return response()->json([
                'msg' => 'Partido guardado con exito',
                'data' => $match
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => 'Se ha producido un error al intentar guardar el partido , intente de nuevo mas tarde',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        try {

            $matches = Matches::with('teamHome', 'teamAway', 'season', 'tournament')->find($id);

            if (!$matches) {
                return response()->json([
                    'msg' => 'Partido no encontrado',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'msg' => 'Partido obtenido con exito',
                'data' => $matches
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => 'Se ha producido un error al intentar obtener el partido , intente de nuevo mas tarde',
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $match = Matches::find($id);

            if (!$match) {
                return response()->json([
                    'msg' => 'Partido no encontrado',
                    'data' => null
                ], 404);
            }

            $data = $request->validate([
                'user_id' => 'required',
                'team_id_home' => 'required',
                'team_id_away' => 'required',
                'location' => 'sometimes|string',
                'cc' => 'required|string',
                'date' => 'required|date',
                'season_id' => 'required|integer',
                'tournament_id' => 'required|integer',
                'score_home' => 'nullable',
                'score_away' => 'nullable',
                'winner_id' => 'nullable',
                'result' => 'nullable',
            ]);

            //no puede ser el mismo equipo en el partido
            if ($data['team_id_home'] == $data['team_id_away']) {
                return response()->json([
                    'msg' => 'El equipo local no puede ser el mismo que el equipo visitante',
                    'data' => null
                ], 404);
            }


            $match->update($data);

            $match->load('teamHome', 'teamAway', 'season');

            return response()->json([
                'msg' => 'Partido actualizado con exito',
                'data' => $match
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => 'Se ha producido un error al intentar actualizar el partido , intente de nuevo mas tarde',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {

            $match = Matches::find($id);
            $match->delete();
            return response()->json([
                'msg' => 'Partido eliminado con exito',
                'data' => $match
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => 'Se ha producido un error al intentar eliminar el partido , intente de nuevo mas tarde',
            ], 400);
        }
    }
}
