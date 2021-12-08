<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ticket;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\BusRequest;
use App\Repositories\BusRepository;
use App\Http\Requests\UpdateRequest;
use App\Http\Traits\ProjectResponse;
use App\Repositories\CompanyRepository;
use App\Repositories\TicketRepositories;
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

    public function __construct(CompanyRepository $companyRepository)
    {
        //get the company id using token
        $user_name = auth('api')->user()->name;
        $this->company_id = $companyRepository->getId($user_name);
    }
    public function store(BusRequest $request, BusRepository $busRepository)

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


        $bus = $busRepository->create($data);
        return $this->showMessage('Done successfully!');
    }


//    //show all available buses in main page
//    public function userShow()
//    {
//        $buses = Bus::where('available', 1)->get();
//    }


    //show available and non available buses for specific company
    public function companyShow(BusRepository $busRepository)
    {
        $buses = $busRepository->companyShow($this->company_id);
        return $this->showData($buses);
    }


    //array intersect
    public function update(UpdateRequest $request, BusRepository $busRepository)
    {
        $message = '';
        if($request->filled('name')) {
            $busRepository->update($request->id, 'name', $request->name);
            $message .= "Name of current bus has been updated. ";
        }

        if($request->filled('sites')) {
            $busRepository->update($request->id, 'sites', $request->sites);
            $message .= "Sites number has been updated. ";
        }

        if($request->filled('grade')) {
            $busRepository->update($request->id, 'grade', $request->grade);

            $message .= "Grade has been updated. ";
        }

        if($request->filled('air_conditioning')) {
            $busRepository->update($request->id, 'air_conditioning', $request->air_conditioning);

            $message .= "Air_conditioning of bus has been updated. ";
        }

        //if there is no messages then nothing was sent to be changed
        if($request->filled('file')) {
            $busRepository->update($request->id, 'file_path', $request->file->hashName());
            $request->file->store('busImage', 'public'); //save the file locally in storage/public under a new folder named /busImage
            $message .= "Bus image has been updated. ";
        }

        if(empty($message)) {
            $message .= "There is nothing to update";
        }

        return $this->showMessage($message);
    }


    //update available column in both buses and tickets table
    public function archive(Request $request, BusRepository $busRepository, TicketRepositories $ticketRepositories)
    {
        $busRepository->update($request->id, 'available', 0);
        $ticket_exist = $ticketRepositories->getBus($request->id);

        if($ticket_exist->isNotEmpty()) {
            $ticketRepositories->busUpdate($request->id, 'available', 0);

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
    public function addComment(Request $request, BusRepository $busRepository)
    {
        $busRepository->update($this->company_id, 'comments', $request->comment);
        return $this->showMessage('comment has been inserted');
    }
}
