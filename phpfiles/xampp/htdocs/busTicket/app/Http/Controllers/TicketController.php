<?php
/**
 *      how to add multiple records
 */
namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateRequest;
use App\Http\Requests\TicketRequest;

class TicketController extends Controller
{
    public function store(TicketRequest $request)
    {
        $data = [
            "number" => $request->number,
            "starting_date_time" => $request->starting_date_time,
            "beginning" => $request->beginning,
            "destination" => $request->destination,
            "price" => $request->price,
            "bus_id" => $request->bus_id,
        ];

        $request->validated(); //applying validation requests

        $ticket = Ticket::create($data);
        return response()->json(['message' => 'Done successfully!'], 200);
    }

    public function show(Request $request)
    {
        //
    }

    //check if fields are filled and update them
    public function update(UpdateRequest $request)
    {
        $message = '';
        if($request->filled('number')) {
            Ticket::where('id', $request->id)->update(['number' => $request->number]);
            $message .= "Number of tickets is updated. ";
        }

        if($request->filled('starting_date_time')) {
            Ticket::where('id', $request->id)->update(['starting_date_time' => $request->starting_date_time]);
            $message .= "Starting_data_time of tickets is updated. ";
        }

        if($request->filled('beginning')) {
            Ticket::where('id', $request->id)->update(['beginning' => $request->beginning]);
            $message .= "Beginning of tickets is updated. ";
        }

        if($request->filled('destination')) {
            Ticket::where('id', $request->id)->update(['destination' => $request->destination]);
            $message .= "Destination of tickets is updated. ";
        }

        //if there is no messages then nothing was sent to be changed
        if($request->filled('price')) {
            Ticket::where('id', $request->id)->update(['price' => $request->price]);
            $message .= "Price of tickets is updated. ";
        }

        if(empty($message)) {
            $message .= "There is nothing to update";
        }

        return response()->json(['message' => $message], 200);
    }
}
