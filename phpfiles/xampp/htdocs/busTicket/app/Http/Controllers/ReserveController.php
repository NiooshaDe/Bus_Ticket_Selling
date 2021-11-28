<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketUser;
use Illuminate\Http\Request;
use App\Jobs\ProcessReserve;
use Illuminate\Http\Response;
use App\Http\Traits\ProjectResponse;
use Illuminate\Database\Eloquent\Builder;

class ReserveController extends Controller
{
    use ProjectResponse;
    public $id;

    //expires certain values
    public function __construct()
    {
        $reserves = TicketUser::where('reserved', 0)->where('expired', 0)->get();
        if($reserves->isNotEmpty()) {
            foreach ($reserves as $reserve) {
                if (Carbon::now()->subMinutes(15) >= $reserve->created_at) {
                    TicketUser::where('id', $reserve->id)->update(['expired' => 1, 'updated_at' => Carbon::now()]);
                }
//                $this->dispatch(new ProcessReserve($reserve->id))->delay($reserve->updated)
            }
        }
    }

    //shows reserved and unreserved seats
    public function show(Request $request)
    {
        $user = User::with('tickets')->whereHas('tickets', function ($query) use ($request){
            $query->where('ticket_id', $request->ticket_id)
                ->where('reserved', 1)
                ->orWhere('expired', 0);
        })->get(['id', 'gender']);
        return $user;

    }

    //user can reserve a seat
    public function reserve(Request $request)
    {
        $data = [
            'ticket_id' => $request->ticket_id,
            'user_id' =>  auth('api')->user()->id,
            'seat_number' => $request->seat_number,
            'expired' => 0,
            'reserved' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $reserve = TicketUser::insert($data);

        if($reserve == false) {
            return $this->getErrors('something wrong with reserve', Response::HTTP_BAD_REQUEST);
        }

        return $this->showMessage('reserved successfully');
    }

    //current user bought tickets and the total price
    public function receipt()
    {
        $id = auth('api')->user()->id;

        $price = Ticket::with('users')->
        whereHas('users', function ($query) use ($id){
        $query->where('user_id', $id)
            ->where('reserved', 0)
            ->where('expired', 0);
        })->
        get(['price']);

        return $this->showData($price);
    }
}
