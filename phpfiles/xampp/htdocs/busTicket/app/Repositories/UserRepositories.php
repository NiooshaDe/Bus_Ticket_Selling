<?php


namespace App\Repositories;

use App\Models\User;

class UserRepositories implements TicketUserModelsRepositories
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function show($ticket_id)
    {
        return $this->model->with('tickets')->whereHas('tickets', function ($query) use ($ticket_id){
            $query->where('ticket_id', $ticket_id)
                ->where('reserved', 1)
                ->orWhere('expired', 0);
        })->get(['gender', 'id']);
    }

    public function create($companyData)
    {
        return $this->model->create($companyData);
    }
}
