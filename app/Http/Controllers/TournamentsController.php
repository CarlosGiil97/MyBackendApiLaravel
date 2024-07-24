<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Tournament;

class TournamentsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::all();
        return response()->json($tournaments);
    }

    public function indexWithMatches()
    {
        $query = Tournament::with(['matches.teamHome', 'matches.teamAway'])
            ->orderBy('date_start');

        $date = request()->input('date');
        $startDate = request()->input('start_date');
        $endDate = request()->input('end_date');


        if ($date) {
            $date = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        }
        if ($startDate) {
            $startDate = Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
        }
        if ($endDate) {
            $endDate = Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
        }

        $query->when($date, function ($q) use ($date) {
            $q->whereDate('date_start', '<=', $date)
                ->whereDate('date_end', '>=', $date);
        });

        // Filtrar por rango de fechas
        $query->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
            $q->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date_start', [$startDate, $endDate])
                    ->orWhereBetween('date_end', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('date_start', '<=', $startDate)
                            ->where('date_end', '>=', $endDate);
                    });
            });
        });

        $tournaments = $query->get();

        return response()->json($tournaments);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Tournament::where('name', $request->name)->where('season_id', $request->season_id)->exists()) {
            return response()->json([
                'msg' => 'El torneo ' . $request->year . ' ya existe en nuestro sistema con este nombre y esta temporada',
                'data' => null
            ], 404);
        }

        try {
            $data = $request->validate([
                'name' => 'required|string',
                'season_id' => 'required|integer',
                'date_start' => 'required|date',
                'date_end' => 'required|date',
                'image' => 'sometimes|image',
            ]);

            //la fecha de fin no puede ser menor a la fecha de inicio
            if ($data['date_start'] > $data['date_end']) {
                return response()->json([
                    'msg' => 'La fecha de fin no puede ser menor a la fecha de inicio',
                    'data' => null
                ], 404);
            }


            $tournament = Tournament::create($data);

            // Retorna la respuesta con éxito
            return response()->json([
                'msg' => 'Torneo guardado con exito',
                'data' => $tournament
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
            $tournament = Tournament::find($id);

            if (!$tournament) {
                return response()->json([
                    'msg' => 'Torneo no encontrado',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'msg' => 'Torneo obtenido con éxito',
                'data' => $tournament
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
            $tournament = Tournament::find($id);

            if (!$tournament) {
                return response()->json([
                    'msg' => 'Torneo no encontrado',
                    'data' => null
                ], 404);
            }

            $data = $request->validate([
                'name' => 'required|string',
                'season_id' => 'required|integer',
                'date_start' => 'required|date',
                'date_end' => 'required|date',
                'image' => 'sometimes|image',
            ]);

            $tournament->update($data);

            return response()->json([
                'msg' => 'Torneo actualizado con éxito',
                'data' => $tournament
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
            $tournament = Tournament::find($id);
            $tournament->delete();
            return response()->json([
                'msg' => 'Torneo eliminado con exito',
                'data' => $tournament
            ], 201);
        } catch (\Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }
}
