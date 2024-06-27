<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;

class UserProfileController extends Controller
{

    public function index()
    {
        $profiles = UserProfile::all();
        return response()->json($profiles);
    }

    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'sometimes|max:10',
            ]);

            $profile = UserProfile::create($data);
            return response()->json([
                'msg' => 'Información guardada con exito',
                'data' => $profile
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al guardar la información',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $profile = UserProfile::where('user_id', $id)->with('user')->first();
            return response()->json([
                'msg' => 'Información encontrada',
                'data' => $profile
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'msg' => 'Información no encontrada',
                'data' => null
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $profile = UserProfile::where('user_id', $id)->with('user')->first();

            $data = $request->validate([
                'first_name' => 'sometimes|required|string|max:255',
                'last_name' => 'sometimes|required|string|max:255',
                'phone' => 'sometimes|max:10',
                'address' => 'sometimes|max:255',
                'city' => 'sometimes|max:255',
                'country' => 'sometimes|max:255',
                'postcode' => 'sometimes|max:255',
                'date_of_birth' => 'sometimes|max:255',
                'hobbies' => 'sometimes|max:255',
                'skills' => 'sometimes|max:255',
            ]);

            $profile->update($data);

            return response()->json([
                'msg' => 'Información actualizada con exito',
                'data' => $profile
            ], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'msg' => 'Información no encontrada',
                'data' => null
            ], 404);
        }
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        try {
            $profile = UserProfile::findOrFail($id);
            $profile->delete();
            return response()->json([
                'msg' => 'Información eliminada con exito',
            ], 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'msg' => 'Información no encontrada',
                'data' => null
            ], 404);
        }
    }
}
