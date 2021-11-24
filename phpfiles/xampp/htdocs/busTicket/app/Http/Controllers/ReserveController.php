<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ProjectResponse;

class ReserveController extends Controller
{
    public $request;
    use ProjectResponse;
    //shows reserved and unreserved seats
    public function show(Request $request)
    {
        $this->request = $request->bus_id;
        var_dump($this->request);
        $result = User::with('tickets')->whereHas('tickets', function ($query) {
            $query->where('bus_id', $this->request);
        })->get();
        return $result;
    }

    //user can reserve a seat
    public function reserve()
    {

    }
}
