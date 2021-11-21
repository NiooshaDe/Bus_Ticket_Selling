<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ticket;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Traits\ProjectResponse;

//controls data's which should be shown in landing page
class LandingPageController extends Controller
{
    use ProjectResponse;

    public $date, $request;

    //shows some random companies
    public function showCompanies()
    {
        $companies = Company::all()->random(3);

        return $this->showData($companies);
    }

    //shows some random comments
    public function showComments()
    {
        $comments = Company::all(['comments'])->random(1);
        return $this->showData($comments);
    }

    //shows buses which travel in current date having beginning and destination
    public function showBuses(Request $request)
    {
        $this->date = Carbon::parse($request->date)->format('Y-m-d');
        $this->request = $request;

        $buses = Bus::with('tickets')->whereHas('tickets', function ($query) {
            $query->whereDate('tickets.starting_date_time', $this->date)
            ->where('tickets.beginning', $this->request->beginning)
            ->where('tickets.destination', $this->request->destination)
            ->orderBy('tickets.starting_date_time', 'asc');
        })->where('available', 1)->get();

        return $this->showData($buses);
    }

    //filters applying on tickets
    public function filter(Request $request)
    {
        $this->request = $request;
        $output = Bus::with('tickets')->whereHas('tickets', function ($query) {
            $query->filter($this->request)->orderBy('starting_date_time', 'asc');
        })->where('available', 1)->filter($request)->get();

        //to check if there is a bus with such specifications
        if($output->isEmpty()) {
            return $this->getErrors('there is no such bus available', Response::HTTP_BAD_REQUEST);
        }

        return $this->showData($output);
    }
}
