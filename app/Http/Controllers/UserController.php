<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    //obtener profile de un usuario
    public function profile($id)
    {

        try {
            $user = User::find($id);

            return response([
                'data' => $user->profile,
            ], 200);
        } catch (Exception $e) {
            return response([
                'msg' => $e->getMessage()
            ], 400);
        }
    }
}
