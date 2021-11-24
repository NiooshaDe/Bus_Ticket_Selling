<?php
namespace App\Repositories;
use App\Models\Company;

class ShowCompaniesRepository implements LandingRepositoryInterface
{
    protected $model;
    public function __construct(\Illuminate\Database\Eloquent\Model $model)
    {
        $this->model = $model;
    }
    public function showCompanies()
    {
        // TODO: Implement showCompanies() method.
        return $this->model->all()->random(3);

    }
}
