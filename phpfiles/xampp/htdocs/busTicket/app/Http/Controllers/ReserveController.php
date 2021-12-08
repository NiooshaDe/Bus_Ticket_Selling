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
use function PHPUnit\Framework\isEmpty;

class ReserveController extends Controller
{
    use ProjectResponse;
    public $id;


    //shows reserved and unreserved seats
    public function show(ShowTicketsRequest  $request, UserRepositories $user_repository, TicketUserRepositories $ticket_user_repository)
    {
        $users = $user_repository->show($request->ticket_id);

        $datas = $ticket_user_repository->show($request->ticket_id);

        $output = [];
        foreach ($users as $user) {
            foreach ($datas as $data)  {
                if ($data->user_id == $user->id) {
                    $output += ["gender" => $user->gender, "seat_number" => $data->seat_number];
                }
            }
        }

        return $this->showData($output);
    }


    //user can reserve a seat
    public function reserve(ReserveRequest $request, TicketUserRepositories $ticket_user_repository)
    {


        $items = $request->all();

        foreach($items['items'] as $item) {
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

            $id = $ticket_user_repository->store($data);

            //expire after 15 minutes automatically
            ProcessReserve::dispatch($id)->delay(900)->onConnection('database');

            if(isEmpty($id)) {
                return $this->getErrors('something wrong with reserve', Response::HTTP_BAD_REQUEST);
            }
        }


        return $this->showMessage('reserved successfully');
    }


    //current user bought tickets and the total price
    public function receipt(TicketRepositories $ticket_repository, TicketUserRepositories $ticket_user_repository)
    {

        $user = auth('api')->user();


        $id = $user->id;

        if (isEmpty($ticket_repository->reserveShow($id))) {
            return $this->getErrors('There is nothing to show', Response::HTTP_EXPECTATION_FAILED);
        }

        $price = $ticket_repository->reserveShow($id)[0]->price;
        $total_price = $ticket_user_repository->count($id) * $price;

        $output = [];
        $output += ["price" => $price, "total_price" => $total_price, "user_name", $user->name];

        return $this->showData($output);
    }
}
