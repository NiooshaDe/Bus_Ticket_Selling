<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ticket;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Traits\ProjectResponse;
use App\Repositories\ShowCompaniesRepository;

//controls data's which should be shown in landing page
class LandingPageController extends Controller
{
    use ProjectResponse;

    public $date, $request;
    protected $model;

    public function __construct(Company $company)
    {
        $this->model = new ShowCompaniesRepository($company);
    }

    //shows some random companies
    public function showCompanies()
    {
        $companies = $this->model->showCompanies();

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
            $query->filter($this->request)->whereDate('tickets.starting_date_time', $this->date)
            ->where('tickets.beginning', $this->request->beginning)
            ->where('tickets.destination', $this->request->destination)
            ->orderBy('tickets.starting_date_time', 'asc');
        })->where('available', 1)->filter($request)->get();

        return $this->showData($buses);
    }


}
