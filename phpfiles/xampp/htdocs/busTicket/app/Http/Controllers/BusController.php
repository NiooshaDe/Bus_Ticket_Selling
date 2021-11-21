<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ticket;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\BusRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Traits\ProjectResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;


//storing new buses
// archiving them
// show all buses to users
// show buses to companies [owners]
// updating bus information by company

class BusController extends Controller
{
    use  HasFactory, ProjectResponse;

    public $company_id;

    public function __construct()
    {
        //get the company id using token
        $user_name = auth('api')->user()->name;
        $this->company_id = Company::where('name', $user_name)->first()->id;
    }
    public function store(BusRequest $request)

    {
        $file_path = 'Null';

        if (!empty($request->file())) {
            $file_path = $request->file->hashName();
            $request->file->store('busImage', 'public'); //save the file locally in storage/public under a new folder named /busImage
        }


        $data = [
            "name" => $request->name,
            "sites" => $request->sites,
            "grade" => $request->grade,
            "air_conditioning" => $request->air_conditioning,
            "available" => 1, //every input bus is available from the beginning
            "file_path" => $file_path, //image path storing in database using hash
            "company_id" => $this->company_id
        ];

        $bus = Bus::create($data);
        return $this->showMessage('Done successfully!');
    }


    //show all available buses in main page
    public function userShow()
    {
        $buses = Bus::where('available', 1)->get();
    }


    //show available and non available buses for specific company
    public function companyShow()
    {
        $buses = Bus::where('company_id', $this->company_id)->where('available', 1)->get();
        return $this->showData($buses);
    }


    //array intersect
    public function update(Request $request)
    {
        $message = '';
        if($request->filled('name')) {
            Bus::where('id', $request['id'])->update(['name' => $request->name]);
            $message .= "Name of current bus has been updated. ";
        }

        if($request->filled('sites')) {
            Bus::where('id', $request->id)->update(['sites' => $request->sites]);
            $message .= "Sites number has been updated. ";
        }

        if($request->filled('grade')) {
            Bus::where('id', $request->id)->update(['grade' => $request->grade]);
            $message .= "Grade has been updated. ";
        }

        if($request->filled('air_conditioning')) {
            Bus::where('id', $request->id)->update(['air_conditioning' => $request->air_conditioning]);
            $message .= "Air_conditioning of bus has been updated. ";
        }

        //if there is no messages then nothing was sent to be changed
        if($request->filled('file')) {
            Bus::where('id', $request->id)->update(['file_path' => $request->file->hashName()]);
            $request->file->store('busImage', 'public'); //save the file locally in storage/public under a new folder named /busImage
            $message .= "Bus image has been updated. ";
        }

        if(empty($message)) {
            $message .= "There is nothing to update";
        }

        return $this->showMessage($message);
    }


    //update available column in both buses and tickets table
    public function archive(Request $request)
    {
        $bus = Bus::where('id', $request->id)->update(['available' => 0]);

        $ticket_exist = Ticket::with('buses')->where('tickets.bus_id', $request->id)->get();

        if($ticket_exist->isNotEmpty()) {
            $ticket = Ticket::with('buses')->where('tickets.bus_id', $request->id)->update(['available' => 0]);
            $ticket_message =  'Current bus tickets are archived';
        }

        else {
            $ticket_message = "Current bus doesn't have any tickets";
        }

        $bus_message = 'Chosen bus has been archived successfully';
        $total_message = $bus_message . $ticket_message;
        return $this->showMessage($total_message);
    }

    //company adds comment to comments column
    public function addComment(Request $request)
    {
        Company::where('id', $this->company_id)->update('comments', $request->comment);
        return $this->showMessage('comment has been inserted');
    }
}
