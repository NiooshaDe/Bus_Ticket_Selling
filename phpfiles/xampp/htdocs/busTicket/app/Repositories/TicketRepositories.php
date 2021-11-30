<?php


namespace App\Repositories;


use App\Models\Ticket;

class TicketRepositories implements TicketUserModelsRepositories
{
    protected $model;

    public function __construct()
    {
        $this->model = new Ticket();
    }

    public function show($id)
    {
        // TODO: Implement show() method.

        return $this->model->with('users')->
        whereHas('users', function ($query) use ($id){
            $query->where('user_id', $id)
                ->where('reserved', 0)
                ->where('expired', 0);
        })->get(['price']);
    }


}
