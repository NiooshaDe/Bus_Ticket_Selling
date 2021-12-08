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


    //the one used in ReservedController
    public function reserveShow($id)
    {
        // TODO: Implement show() method.

        return $this->model->with('users')->where('available', 1)->
        whereHas('users', function ($query) use ($id){
            $query->where('user_id', $id)
                ->where('reserved', 0)
                ->where('expired', 0);
        })->get();
    }


    //the one used in TicketController
    public function showTickets($input)
    {
        return $this->model->where('bus_id', $input)->where('available', 1)->get();
    }


    //the one used in BusController and updates using bus_id
    public function busUpdate($bus_id, $column, $content)
    {
        return $this->model->with('buses')->where('tickets.bus_id', $bus_id)->update([$column => $content]);
    }

    //the one gets tickets using bus_id
    public function getBus($bus_id)
    {
        return $this->model->with('buses')->where('tickets.bus_id', $bus_id)->get();;
    }

}
