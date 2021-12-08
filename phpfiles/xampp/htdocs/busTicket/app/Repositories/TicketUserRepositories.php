<?php


namespace App\Repositories;


use App\Models\TicketUser;
use Carbon\Carbon;

class TicketUserRepositories implements TicketUserModelsRepositories
{
    protected $model;

    public function __construct()
    {
        $this->model = new TicketUser();
    }

    public function show($ticket_id)
    {
        return $this->model->where('ticket_id', $ticket_id)->get();
    }

    public function store($data)
    {
        return $this->model->insertGetId($data);
    }


    public function expireGet()
    {
        return $this->model->where('reserved', 0)->where('expired', 0)->get();
    }

    public function expire($id)
    {
        return $this->model->where('id', $id)->update(['expired' => 1, 'updated_at' => Carbon::now()]);
    }

    public function count($user_id)
    {
        return $this->model->where('user_id', $user_id)->where('reserved', 0)
            ->where('expired', 0)->get()->count();
    }

    public function updateTransaction($transaction_id)
    {
        return $this->model->update(['transaction_id', $transaction_id]);
    }
}
