<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ticket;
use App\Models\Company;
use App\Repositories\BusRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Traits\ProjectResponse;
use App\Repositories\CompanyRepository;

//controls data's which should be shown in landing page
class LandingPageController extends Controller
{
    use ProjectResponse;


    //shows some random companies
    public function showCompanies(CompanyRepository $company_repository)
    {
        $companies = $company_repository->show();

        return $this->showData($companies);
    }


    //shows some random comments
    public function showComments(CompanyRepository $company_repository)
    {
        $comments = $company_repository->showComments();
        return $this->showData($comments);
    }


    //shows buses which travel in current date having beginning and destination
    public function showBuses(Request $request, BusRepository $busRepository)
    {
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $buses = $busRepository->show($request, $date, $request->beginning, $request->destination);

        if($buses->isEmpty()) {
            return $this->getErrors('No such data', Response::HTTP_NOT_FOUND);
        }

        return $this->showData($buses);
    }


}
