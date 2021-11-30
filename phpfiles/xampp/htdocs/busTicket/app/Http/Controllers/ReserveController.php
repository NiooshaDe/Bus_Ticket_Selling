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
use App\Http\Requests\ReserveRequest;
use App\Repositories\UserRepositories;
use App\Repositories\TicketRepositories;
use App\Http\Requests\ShowTicketsRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\TicketUserRepositories;

class ReserveController extends Controller
{
    use ProjectResponse;
    public $id;

    //expires certain values
    public function __construct()
    {
        $reserves = new TicketUserRepositories();
        $reserves = $reserves->expireGet();

        if($reserves->isNotEmpty()) {
            foreach ($reserves as $reserve) {
                if (Carbon::now()->subMinutes(15) >= $reserve->created_at) {
                    $reserveExpire = new TicketUserRepositories();
                    $reserveExpire->expire($reserve->id);
                }
//                $this->dispatch(new ProcessReserve($reserve->id))->delay($reserve->updated)
            }
        }
    }

    //shows reserved and unreserved seats
    public function show(ShowTicketsRequest  $request)
    {
        $users = new UserRepositories();
        $users = $users->show($request->ticket_id);

        $datas = new TicketUserRepositories();
        $datas = $datas->show($request->ticket_id);

        $output = [];
        foreach ($users as $user) {
            foreach ($datas as $data)  {
                if ($data->user_id == $user->id) {
                    $output += ["$user->gender" => $data->seat_number];
                }
            }
        }

        return $this->showData($output);
    }


    //user can reserve a seat
    public function reserve(ReserveRequest $request)
    {
        //checks if user is logged in
        if(empty(auth('api')->user())) {
            return $this->getErrors('unauthorized', Response::HTTP_FORBIDDEN);
        }

        $items = $request->all();

        foreach($items['items'] as $item) {
            $item_id = $item['item_id'];
            $ticket_id = $item['ticket_id'];
            $seat_number = $item['seat_number'];

            $data = [
                'ticket_id' => $ticket_id,
                'user_id' => auth('api')->user()->id,
                'seat_number' => $seat_number,
                'expired' => 0,
                'reserved' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $reserve = TicketUser::insert($data);
        }


        if($reserve == false) {
            return $this->getErrors('something wrong with reserve', Response::HTTP_BAD_REQUEST);
        }

        return $this->showMessage('reserved successfully');
    }


    //current user bought tickets and the total price
    public function receipt()
    {

        $user = auth('api')->user();

        //checks if user is logged in
        if(empty($user)) {
            return $this->getErrors('unauthorized', Response::HTTP_FORBIDDEN);
        }

        $id = $user->id;

        $price = new TicketRepositories();
        $price = $price->show($id)[0]->price;

        $total_price = new TicketUserRepositories();
        $total_price = $total_price->count($id) * $price;

        $output = [];
        $output += ["price" => $price, "total_price" => $total_price];

        return $this->showData($output);
    }
}
