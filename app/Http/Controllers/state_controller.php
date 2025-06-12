<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_state;

class state_controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewState()
    {
        $states = tb_state:: all();

        return response() -> json($states, 200);
    }
}
