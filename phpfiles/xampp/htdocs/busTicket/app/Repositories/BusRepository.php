<?php


namespace App\Repositories;


use App\Models\Bus;

class BusRepository
{
    public $model;
    public function __construct()
    {
        $this->model = new Bus();
    }


    public function show($request, $date, $beginning, $destination)
    {
        return $this->model->with('tickets')->whereHas('tickets', function ($query) use ($request, $date, $beginning, $destination){
            $query->filter($request)->whereDate('tickets.starting_date_time', $date)
                ->where('tickets.beginning', $beginning)
                ->where('tickets.destination', $destination)
                ->orderBy('tickets.starting_date_time', 'asc');
        })->where('available', 1)->filter($request)->get();
    }

    //shows buses using their company_id
    public function companyShow($company_id)
    {
        return $this->model->where('company_id', $company_id)->where('available', 1)->get();
    }


    public function update($bus_id, $column, $content)
    {
        return $this->model->where('id', $bus_id)->update([$column => $content]);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
