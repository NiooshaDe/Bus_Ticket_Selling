<?php
namespace App\Repositories;
use App\Models\Company;

class CompanyRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = new Company();
    }


    public function show()
    {
        return $this->model->where('available', 1)->all()->random(3);
    }


    public function showComments()
    {
        return $this->model->all(['comments'])->random(1);
    }


    public function create($companyData)
    {
        return $this->model->create($companyData);
    }


    //using the user name
    public function getId($user_name)
    {
        return $this->model->where('name', $user_name)->first()->id;
    }

}
